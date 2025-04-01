<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Bank;
use App\Models\RentCard;
use App\Models\InvoiceItem;
use App\Models\RentItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    
    public function superadmin_index(Request $request)
    {
        $new_card = Card::where('is_approved',null)->get();
        $reject_card = Card::where('is_approved',2)->get();
        $approve_card = Card::where('is_approved',1)->get();
        $case_card = Card::where('is_approved',3)->get();
        $bank = Bank::all();
        $count = Card::count();
        $approve_card  = Card::where('is_approved',1)->get();
        $approve_count = $approve_card->count();
        $cost = $approve_card->sum('cost');
        $approve_cost = $approve_card->sum('cost');
        return view('card.admin_index')->with('new_card',$new_card)->with('reject_card',$reject_card)->with('approve_card',$approve_card)->with('case_card',$case_card)->with('bank',$bank)->with('count',$count)->with('cost',$cost)->with('approve_count',$approve_count)->with('approve_cost',$approve_cost);
    }

    public function index(Request $request)
    {
        // dd($request->all());
        $now = Carbon::now();
        $agent_id = 0;
        $filter = $request->query('filter');
        if($filter == null){
            $filter = $now->format('Y-m');
        }
        if(isset($request->agent_id)){
            $agent_id = $request->agent_id;
        }
        if(Auth::user()->role == "Agent"){
            $agent_id = Auth::user()->id;
        }
        $datefilter = Carbon::parse($filter);
        $user = User::where('role','Agent')->pluck('id')->toArray();
        if($agent_id >0){
            $card = Card::where('user_id',$agent_id)->get();
            $rent_count = RentCard::where('year',$datefilter->year)->where('month',$datefilter->month)->where('user_id',$agent_id)->count();
            $rent_cost = RentCard::where('year',$datefilter->year)->where('month',$datefilter->month)->where('user_id',$agent_id)->sum('price');
            $invoice_item = InvoiceItem::where('year',$datefilter->year)->where('month',$datefilter->month)->where('user_id',$agent_id)->sum('price');
        }else{
            $card = Card::all();
            $rent_count = RentCard::where('year',$datefilter->year)->where('month',$datefilter->month)->count();
            $rent_cost = RentCard::where('year',$datefilter->year)->where('month',$datefilter->month)->sum('price');
            $invoice_item = InvoiceItem::where('year',$datefilter->year)->where('month',$datefilter->month)->sum('price');
        }
        $approve_count = $card->where('is_approved',1)->count();
        $bank = Bank::all();
        $agent = User::where('role','Agent')->get();
        
        
        return view('card.index')->with('card',$card)->with('bank',$bank)->with('rent_count',$rent_count)->with('approve_count',$approve_count)->with('agent',$agent)->with('filter',$filter)->with('agent_id',$agent_id)->with('rent_cost',$rent_cost)->with('invoice_item',$invoice_item)->with('year',$datefilter->year)->with('month',$datefilter->month);
    }

    public function store(Request $request)
    {
        if($request->card_id>0){
            $card=Card::find($request->card_id);
            $card->update($request->all());
        }else{
            $request->merge(['from_who'=>Auth::user()->id]);
            $card=Card::create($request->all());  
        }  
        return redirect()->back();
    }

    public function destroy(Card $card)
    {
        $card->delete();

        return redirect()->route('card.index');
    }

    
    public function view_rent(Card $card)
    {
        return view('card.view_rent')->with('card',$card);
    }

    public function setReject(Card $card)
    {
        $card->update(['is_approved'=>2]);

        return redirect()->back();
    }

    public function setCase(Card $card)
    {
        $card->update(['is_approved'=>3]);

        return redirect()->back();
    }

    public function setApprove(Request $request)
    {
        //dd($request->all());
        $now=Carbon::now();
        $card = Card::find($request->card_idd);
        $card->update(['is_approved'=>1,'approved_by'=>Auth::user()->id,'approved_date'=>$now,'initial_payment'=>$request->initial_cost,'from_price'=>$request->monthly_cost]);

        // $findRentItem = RentItem::where('card_id',$card->id)->where('year',$now->year)->where('month',$now->month)->first();
        // if(isset($findRentItem)){
        //     $findRentItem->update(['amount'=>$request->initial_cost]);
        // }else{
        //     $findRentItem = RentItem::create(['year'=>$now->year,'month'=>$now->month,'card_id'=>$card->id,'amount'=>$request->initial_cost]);
        // }
        return redirect()->back();
    }
   
}
