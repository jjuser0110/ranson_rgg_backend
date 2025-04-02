<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Card;
use App\Models\Bank;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\RunningNo;
use App\Models\Payment;
use App\Models\RentCard;
use App\Models\Rent;
use App\Models\Expense;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $now = Carbon::now();
        $filter = $request->query('filter');
        if($filter == null){
            $filter = $now->format('Y-m');
        }

        $total_member = User::whereNotNull('userid')->count();

        $today_transactions = Transaction::whereDate('datetime', $now);
        $today_sales = $today_transactions->sum('amount');
        $today_order = $today_transactions->count();

        $this_month_transactions = Transaction::whereMonth('datetime', $now);
        $this_month_sales = $this_month_transactions->sum('amount');
        $this_month_order = $this_month_transactions->count();

        $data = [
            'total_member' => $total_member,
            'today_sales' => $today_sales,
            'today_order' => $today_order,
            'this_month_sales' => $this_month_sales,
            'this_month_order' => $this_month_order,
        ];

        $today = Carbon::now();
        return view('home')->with('filter', $filter)->with('data', $data);
    }

    public function small_dashboard(Request $request)
    {
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
        if($agent_id>0){
            $user = array($agent_id);
        }
        $year = $datefilter->year;
        $month = $datefilter->month;

        $card_rent = InvoiceItem::where('year',$year)->where('month',$month)->whereIn('user_id',$user)->count();
        $total_customer_payment = InvoiceItem::where('year',$year)->where('month',$month)->whereIn('user_id',$user)->sum('price');
        $total_rental = round(RentCard::where('year',$year)->where('month',$month)->whereIn('user_id',$user)->sum('price'),2);
        $total_expenses = Expense::where('year',$year)->where('month',$month)->whereIn('user_id',$user)->sum('amount');
        $total_profit = $total_customer_payment-$total_rental-$total_expenses;

        $data = [
            'card_rent'=> $card_rent,
            'total_customer_payment'=> $total_customer_payment,
            'total_rental'=> $total_rental,
            'total_expenses'=> $total_expenses,
            'total_profit'=> $total_profit,
        ];
        $agent = User::where('role','Agent')->get();
        return view('small_dashboard')->with('filter', $filter)->with('data', $data)->with('agent_id',$agent_id)->with('agent',$agent);
    }

}
