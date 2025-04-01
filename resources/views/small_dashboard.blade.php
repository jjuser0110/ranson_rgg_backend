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
                     <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
								<form class="form-inline" method="GET">
								<div class="form-group mb-2">
									<input type="month" class="form-control" id="filter" name="filter" style="margin-right:10px" value="{{$filter}}" >
								</div>
                        @if(Auth::user()->role == "Masteradmin")
                        <div class="form-group mb-2" style="margin-right:10px">
                           <select class="form-control" name="agent_id">
                              <option value=0>All</option>
                              @foreach($agent as $a)
                              <option value="{{$a->id}}" <?php echo isset($agent_id)&&$agent_id == $a->id?'selected':'' ?>>{{$a->username??''}}</option>
                              @endforeach
                           </select>
                        </div>
                        @endif
								<button type="submit" class="btn btn-primary mb-2" >Search</button>
								</form>
							</div>
                        <div class="col-md-6 col-lg-3">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div> 
                                    <i class="fa fa-bar-chart yellow_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <p class="total_no">{{$data['card_rent']??0}}</p>
                                    <p class="head_couter">All Card Rent</p>
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
                                    <p class="total_no">{{$data['total_customer_payment']??0}}</p>
                                    <p class="head_couter">Customer Payment</p>
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
                                    <p class="total_no">{{$data['total_rental']??0}}</p>
                                    <p class="head_couter">Rent Payment</p>
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
                                    <i class="fa fa-money yellow_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <p class="total_no">{{$data['total_profit']??0}}</p>
                                    <p class="head_couter">Final Profit</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
						

@endsection
