<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Card;
use App\Models\Bank;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\RunningNo;
use App\Models\Payment;
use App\Models\RentCard;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        $user = User::where('role','Customer')->get();
        
        return view('customer.index')->with('user',$user);
    }

    public function view(User $user)
    {
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $card = Card::where('to_who',null)->where('is_approved',1)->where('is_active',1)->get();
        $card_count = $user->customer_cards->count();
        $total_price = $user->invoices->sum('total');
        $payment = $user->payments->sum('amount');
        $outstanding = $total_price-$payment;
        $total_price_current = $user->invoices->where('year',$year)->where('month',$month)->sum('total');
        $payment_current = $user->payments->where('year',$year)->where('month',$month)->sum('amount');
        $outstanding_current = $total_price_current-$payment_current;
        return view('customer.view')->with('user',$user)->with('card',$card)->with('card_count',$card_count)->with('total_price',$total_price)->with('outstanding',$outstanding)->with('outstanding_current',$outstanding_current);
    }

    public function storeCard(Request $request, User $user)
    {
        $request->merge(['to_who'=>$user->id]);
        $card = Card::find($request->select_card);
        $card->update($request->all());
        // dd($request->all());
        $from_month = Carbon::parse($request->from_date)->startOfMonth();
        $this_month = Carbon::now()->startOfMonth();
        $months_array = [];
        while ($from_month->lessThanOrEqualTo($this_month)) {
            $months_array[] = $from_month->format('Y-m'); 
            $from_month->addMonth();
        }
        foreach($months_array as $row=>$mon){
            if($row == 0){
                $start_date = Carbon::parse($request->from_date);
                $start = Carbon::parse($request->from_date);
                $end_date = Carbon::parse($request->from_date)->endOfMonth();
                $end = Carbon::parse($request->from_date)->endOfMonth();
                $year = $start_date->year;
                $month = $start_date->month;
            }else{
                $start_date = Carbon::parse($mon)->startOfMonth();
                $start = Carbon::parse($mon)->startOfMonth();
                $end_date = Carbon::parse($mon)->endOfMonth();
                $end = Carbon::parse($mon)->endOfMonth();
                $year = $start_date->year;
                $month = $start_date->month;
            }
            $checkInvoice = Invoice::where('customer_id',$user->id)->where('year',$year)->where('month',$month)->first();
            if(!isset($checkInvoice)){
                
                $running_no =RunningNo::where('year',$year)->where('month',$month)->first();
                if(isset($running_no)){
                    $invoice_no = $running_no->year.''.sprintf('%02d',$running_no->month).''.sprintf('%05d',$running_no->increment_no);
                }else{
                    $running_no =RunningNo::create(['year'=>$year,'month'=>$month,'increment_no'=>1]);
                    $invoice_no = $running_no->year.''.sprintf('%02d',$running_no->month).''.sprintf('%05d',$running_no->increment_no);
                }
    
                $checkInvoice = Invoice::create(['invoice_no'=>$invoice_no,'customer_id'=>$user->id,'year'=>$year,'month'=>$month]);
                $running_no->update(['increment_no'=>$running_no->increment_no+1]);
            }
            
            $no_of_days = $start_date->diffInDays($end_date)+1;
            if($no_of_days >= 27){
                $no_of_days = 30;
            }
            $price = round($no_of_days/30*$request->to_price);
            
            $owner_price = round($no_of_days/30*$card->from_price);

            $invoiceItem= InvoiceItem::create([
                'invoice_id'=>$checkInvoice->id,
                'card_id'=>$card->id,
                'date_from'=>$start,
                'date_to'=>$end,
                'no_of_days'=>$no_of_days,
                'cost'=>$request->to_price,
                'price'=>$price,
                'year'=>$year,
                'month'=>$month,
                'user_id'=>$card->user_id,
            ]);

            RentCard::create([
                'card_id'=>$card->id,
                'invoice_item_id'=>$invoiceItem->id,
                'user_id'=>$card->user_id,
                'date_from'=>$start,
                'date_to'=>$end,
                'no_of_days'=>$no_of_days,
                'cost'=>$card->from_price,
                'price'=>$owner_price,
                'year'=>$year,
                'month'=>$month,
            ]);
        }

        return redirect()->back();
    }

    public function editInvoiceItem(Request $request){
    //    dd($request->all());
        $invoiceItem = InvoiceItem::find($request->invoice_item_id);
        $invoiceItem->update($request->all());
        $card = Card::find($invoiceItem->card_id);
        $rent_card = RentCard::where('invoice_item_id',$request->invoice_item_id)->first();
        if(isset($rent_card)){
            $no_of_days = $request->no_of_days;
            if($no_of_days > 29){
                $no_of_days = 30;
            }
            $owner_price = round($no_of_days/30*$card->from_price,2);
            $rent_card->update([
                'date_from'=>$request->date_from,
                'date_to'=>$request->date_to,
                'no_of_days'=>$no_of_days,
                'cost'=>$card->from_price,
                'price'=>$owner_price,
            ]);
        }
        return redirect()->back();
    }

    public function destroyItems(InvoiceItem $invoice_item)
    {
        $rent_card = RentCard::where('invoice_item_id',$invoice_item->id)->first();
        if(isset($rent_card)){
            $rent_card->delete();
        }
        $invoice_item->delete();
        return redirect()->back();
    }

    public function generateInvoice(User $user)
    {
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $checkInvoice = Invoice::where('customer_id',$user->id)->where('year',$year)->where('month',$month)->first();
        if(!isset($checkInvoice)){
            
            $running_no =RunningNo::where('year',$year)->where('month',$month)->first();
            if(isset($running_no)){
                $invoice_no = $running_no->year.''.sprintf('%02d',$running_no->month).''.sprintf('%05d',$running_no->increment_no);
            }else{
                $running_no =RunningNo::create(['year'=>$year,'month'=>$month,'increment_no'=>1]);
                $invoice_no = $running_no->year.''.sprintf('%02d',$running_no->month).''.sprintf('%05d',$running_no->increment_no);
            }

            $checkInvoice = Invoice::create(['invoice_no'=>$invoice_no,'customer_id'=>$user->id,'year'=>$year,'month'=>$month]);
            $running_no->update(['increment_no'=>$running_no->increment_no+1]);
        }

        foreach($user->customer_cards as $card){
            $checkInvoiceItem = InvoiceItem::where('card_id',$card->id)->where('year',$year)->where('month',$month)->first();
            if(!isset($checkInvoiceItem)){
                if(Carbon::parse($card->from_date)->month != $now->month){
                    $start_date = Carbon::now()->firstOfMonth()->startOfDay();
                    $from_date = Carbon::now()->firstOfMonth()->startOfDay();
                    $date_start = Carbon::now()->firstOfMonth()->startOfDay();
                }else{
                    $start_date = Carbon::parse($card->from_date);
                    $from_date = Carbon::parse($card->from_date);
                    $date_start = Carbon::parse($card->from_date);
                }

                $date_to = $from_date->lastOfMonth()->endOfDay();

                $no_of_days = $date_start->diffInDays($date_to)+1;
                if($no_of_days >= 27){
                    $no_of_days = 30;
                }
                $price = round($no_of_days/30*$card->to_price,2);
                // $cardApproveDate = Carbon::parse($card->approved_date);
                // if($cardApproveDate->month == $date_start->month && $cardApproveDate->year == $date_start->year){
                //     $cost = $card->initial_payment;
                // }else{
                //     $cost = $card->from_price;
                // }
                $invoiceItem= InvoiceItem::create([
                    'invoice_id'=>$checkInvoice->id,
                    'card_id'=>$card->id,
                    'date_from'=>$start_date,
                    'date_to'=>$date_to,
                    'no_of_days'=>$no_of_days,
                    'cost'=>$card->to_price,
                    'price'=>$price,
                    'year'=>$year,
                    'month'=>$month,
                    'user_id'=>$card->user_id,
                ]);
                

                $owner_price = round($no_of_days/30*$card->from_price,2);
                RentCard::create([
                    'card_id'=>$card->id,
                    'invoice_item_id'=>$invoiceItem->id,
                    'user_id'=>$card->user_id,
                    'date_from'=>$card->from_date,
                    'date_to'=>$date_to,
                    'no_of_days'=>$no_of_days,
                    'cost'=>$card->from_price,
                    'price'=>$owner_price,
                    'year'=>$year,
                    'month'=>$month,
                ]);
            }
        }
        return redirect()->back();

    }

    public function removeCard(Card $card)
    {
        $card->update(['to_who'=>null,'insurance'=>null]);
        return redirect()->back();
    }

    public function updateCard(Request $request){
        //dd($request->all());
        $card = Card::find($request->card_id);
        $card->update(['from_date'=>$request->edit_from_date,'to_date'=>$request->edit_to_date,'to_price'=>$request->edit_to_price,'insurance'=>$request->edit_insurance]);

        return redirect()->back();
    }

    public function pay_receive(Request $request){
        $datetime = Carbon::parse($request->pay_for);
        $request->merge(['month'=>$datetime->month,'year'=>$datetime->year]);
        //dd($request->all());
        Payment::create($request->all());

        return redirect()->back();
    }

    public function destroyPayment(Payment $payment)
    {
        $payment->delete();
        return redirect()->back();
    }
}
