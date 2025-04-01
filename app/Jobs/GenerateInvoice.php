<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Mail;
use App\Models\User;
use App\Models\Card;
use App\Models\Bank;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\RentItem;
use App\Models\RunningNo;
use App\Models\Payment;
use App\Models\Rent;
use App\Models\Expense;
use App\Models\RentCard;

class GenerateInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $month;
    protected $year;
    protected $now;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($month,$year,$now)
    {
        $this->month = $month;
        $this->year = $year;
        $this->now = $now;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $now = $this->now;
        $year = $this->year;
        $month = $this->month;
        $users = User::where('role','Customer')->get();
        foreach($users as $user){
            if($user->customer_cards->count() > 0){
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
                    $from_date = Carbon::parse($now);
                    $date_start = Carbon::parse($now);
                    if($card->to_date != null){
                        $to_date = Carbon::parse($card->to_date);
                        if($month == $to_date->month && $year == $to_date->year){
                            $date_to = $to_date;
                        }else{
                            $date_to = $from_date->endOfMonth();
                        }
                    }else{
                        $date_to = $from_date->endOfMonth();

                    }
                    $no_of_days = $date_start->diffInDays($date_to)+1;
                    if($no_of_days >= 27){
                        $price = $card->to_price;
                    }else{
                        $price = round($no_of_days/30*$card->to_price,2);
                    }
                    $cardApproveDate = Carbon::parse($card->approved_date);
                    if($cardApproveDate->month == $month && $cardApproveDate->year == $year){
                        $cost = $card->initial_payment;
                    }else{
                        $cost = $card->from_price;
                    }
                    $invoiceItem = InvoiceItem::create([
                        'invoice_id'=>$checkInvoice->id,
                        'card_id'=>$card->id,
                        'date_from'=>$date_start,
                        'date_to'=>$date_to,
                        'no_of_days'=>$no_of_days,
                        'cost'=>$cost,
                        'price'=>$price,
                        'year'=>$year,
                        'month'=>$month,
                        'user_id'=>$card->user_id,
                    ]);

                    if($no_of_days >= 27){
                        $owner_price = $card->from_price;
                    }else{
                        $owner_price = round($no_of_days/30*$card->from_price,2);
                    }
                    RentCard::create([
                        'card_id'=>$card->id,
                        'invoice_item_id'=>$invoiceItem->id,
                        'user_id'=>$card->user_id,
                        'date_from'=>$date_start,
                        'date_to'=>$date_to,
                        'no_of_days'=>$no_of_days,
                        'cost'=>$card->from_price,
                        'price'=>$owner_price,
                        'year'=>$year,
                        'month'=>$month,
                    ]);

                }
            }
        }
    }
}
