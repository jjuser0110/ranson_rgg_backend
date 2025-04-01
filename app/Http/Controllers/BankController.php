<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\Bank;
use Carbon\Carbon;

class BankController extends Controller
{
    public function index(Request $request)
    {
        $bank = Bank::all();
        
        return view('bank.index')->with('bank',$bank);
    }

    public function store(Request $request)
    {
        if($request->bank_id>0){
            $bank=Bank::find($request->bank_id);
            $bank->update($request->all());
        }else{
            $bank=Bank::create($request->all());  
        }  
        
        return redirect()->route('bank.index');
    }

    public function destroy(Bank $bank)
    {
        if($bank->cards->count()==0){
            $bank->delete();
            return redirect()->route('bank.index');
        }else{
            return redirect()->back()->withErrors("Bank in used. cannot be delete!");
        }

    }
   
}
