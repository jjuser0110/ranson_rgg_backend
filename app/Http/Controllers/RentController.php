<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\Rent;
use App\Models\RentItem;
use App\Models\User;
use App\Models\RentCard;
use Carbon\Carbon;

class RentController extends Controller
{
    public function index(Request $request)
    {
        $rent = Rent::all();
        $superadmin = User::where('role','Superadmins')->where('is_active',1)->get();
        return view('rent.index')->with('rent',$rent)->with('superadmin',$superadmin);
    }

    public function store(Request $request)
    {
        $date_save = Carbon::parse($request->pay_date);
        $request->merge(['month'=>$date_save->month,'year'=>$date_save->year]);
        if($request->rent_id>0){
            $rent=Rent::find($request->rent_id);
            $rent->update($request->all());
        }else{
            $rent=Rent::create($request->all());  
        }  
        
        return redirect()->route('rent.index');
    }

    public function destroy(Rent $rent)
    {
        $rent->delete();
        return redirect()->route('rent.index');

    }

    

    public function storeRentItem(Request $request)
    {
        if($request->rent_item_id>0){
            $rent=RentCard::find($request->rent_item_id);
            $rent->update($request->all());
        } 
        
        return redirect()->back();
    }

    public function mark_paid(RentCard $rent_item)
    {
        $rent_item->update(['pay_date'=>Carbon::now()]);
        return redirect()->back();

    }

    public function mark_all_pay(Request $request)
    {
        $findrent = RentCard::whereIn('id',$request->rent_ids)->get();
        foreach($findrent as $rent_item){
            $rent_item->update(['pay_date'=>Carbon::now()]);
        }
        return redirect()->back();

    }

    public function destroyitem(RentItem $rent_item)
    {
        $rent_item->delete();
        return redirect()->back();

    }
   
}
