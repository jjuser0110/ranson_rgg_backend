<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transaction = Transaction::all();
        $product_variant = ProductVariant::all();
        
        return view('transaction.index')->with('transaction',$transaction)->with('product_variant',$product_variant);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $transaction=Transaction::create($request->all());  
        
        return redirect()->route('transaction.index');
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
