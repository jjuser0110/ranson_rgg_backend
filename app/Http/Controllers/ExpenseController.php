<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\Expense;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()->role == "Agent"){
            $expense = Expense::where('user_id',Auth::user()->id)->get();
        }else{
            $expense = Expense::all();
        }

        $agent = User::where('role','Agent')->get();
        
        return view('expense.index')->with('expense',$expense)->with('agent',$agent);
    }

    public function store(Request $request)
    {
        $date_save = Carbon::parse($request->claim_date);
        $request->merge(['month'=>$date_save->month,'year'=>$date_save->year]);
        if($request->expense_id>0){
            $expense=Expense::find($request->expense_id);
            $expense->update($request->all());
        }else{
            $expense=Expense::create($request->all());  
        }  
        
        return redirect()->route('expense.index');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expense.index');

    }
   
}
