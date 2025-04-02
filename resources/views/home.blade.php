@extends('layouts.app')

@section('content')
<div class="row column_title">
    <div class="col-md-12">
        <div class="page_title">
            <h2>Dashboard</h2>
        </div>
    </div>
</div>
<div class="row column1">
    <div class="col-md-6 col-lg-3">
        <div class="full counter_section margin_bottom_30">
            <div class="couter_icon">
                <div>
                    <i class="fa fa-bar-chart yellow_color"></i>
                </div>
            </div>
            <div class="counter_no">
                <div>
                    <p class="total_no">{{$data['total_member'] ?? 0 }}</p>
                    <p class="head_couter">Total Member</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="full counter_section margin_bottom_30">
            <div class="couter_icon">
                <div>
                <i class="fa fa-bar-chart blue1_color"></i>
                </div>
            </div>
            <div class="counter_no">
                <div>
                <p class="total_no">RM {{ number_format($data['today_sales'], 2) }}</p>
                <p class="head_couter">Today Sales</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="full counter_section margin_bottom_30">
            <div class="couter_icon">
                <div>
                    <i class="fa fa-bar-chart blue1_color"></i>
                </div>
            </div>
            <div class="counter_no">
                <div>
                    <p class="total_no">{{ $data['today_order'] ?? 0 }}</p>
                    <p class="head_couter">Today Order Count</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <h5>This Month</h5>
</div>
<div class="row column1">
    {{-- <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
        <form class="form-inline" method="GET">
            <div class="form-group mb-2">
                <input type="month" class="form-control" id="filter" name="filter" style="margin-right:10px" value="{{$filter}}" >
            </div>
            <button type="submit" class="btn btn-primary mb-2" >Search</button>
        </form>
    </div> --}}
    <div class="col-md-6 col-lg-3">
        <div class="full counter_section margin_bottom_30">
            <div class="couter_icon">
                <div>
                    <i class="fa fa-bar-chart green_color"></i>
                </div>
            </div>
            <div class="counter_no">
                <div>
                    <p class="total_no">RM {{ number_format($data['this_month_sales'], 2) }}</p>
                    <p class="head_couter">Sales</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="full counter_section margin_bottom_30">
            <div class="couter_icon">
                <div>
                    <i class="fa fa-bar-chart green_color"></i>
                </div>
            </div>
            <div class="counter_no">
                <div>
                    <p class="total_no">{{ $data['this_month_order'] ?? 0 }}</p>
                    <p class="head_couter">Order Count</p>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-md-6 col-lg-3">
        <div class="full counter_section margin_bottom_30">
            <div class="couter_icon">
                <div>
                <i class="fa fa-bar-chart blue1_color"></i>
                </div>
            </div>
            <div class="counter_no">
                <div>
                <p class="total_no">{{$data['profit']??0}}</p>
                <p class="head_couter">Total Profit</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="full counter_section margin_bottom_30">
            <div class="couter_icon">
                <div>
                <i class="fa fa-bar-chart green_color"></i>
                </div>
            </div>
            <div class="counter_no">
                <div>
                <p class="total_no">{{$data['total_expenses']??0}}</p>
                <p class="head_couter">Expenses</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="full counter_section margin_bottom_30">
            <div class="couter_icon">
                <div>
                <i class="fa fa-bar-chart red_color"></i>
                </div>
            </div>
            <div class="counter_no">
                <div>
                <p class="total_no">{{$data['total_profit']??0}}</p>
                <p class="head_couter">Final Profit</p>
                </div>
            </div>
        </div>
    </div> --}}
</div>


@endsection
