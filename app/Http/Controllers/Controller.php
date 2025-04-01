<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Jobs\GenerateInvoice;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    
    public function monthly_invoice()
    {
        $now = Carbon::now();
        //$now=Carbon::parse("2022-08-01");
        $year = $now->year;
        $month = $now->month;
        //dd($year);
        GenerateInvoice::dispatch($month,$year,$now);
        return true;
    }
}
