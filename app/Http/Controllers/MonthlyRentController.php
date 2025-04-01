<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\RentCard;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MonthlyRentController extends Controller
{
    public function index(Request $request)
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $rent_item = RentCard::where('month',$month)->where('year',$year)->get();
        
        return view('rent_item.index')->with('rent_item',$rent_item);
    }
   
}
