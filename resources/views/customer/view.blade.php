@extends('layouts.app')

@section('content')
					<div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>{{$user->name??''}}</h2>
                           </div>
                        </div>
                     </div>
                     <div class="row column1">
							
							<div class="col-lg-12 col-xl-12">
								<div class="card-body">
									<div class="row">
										<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 " style="margin-bottom:10px">
											<div class="card overflow-hidden">
												<div class="card-header">
													<h3 class="card-title" style="color:red">Total Cards</h3>
												</div>
												<div class="card-body ">
													<h2 class="text-dark  mt-0 font-weight-bold">{{$card_count??0}}</h2>
												</div>
											</div>
										</div>
										<div class=" col-sm-12 col-md-6 col-lg-6 col-xl-3"  style="margin-bottom:10px">
											<div class="card overflow-hidden">
												<div class="card-header">
													<h3 class="card-title" style="color:purple">Total Price</h3>
												</div>
												<div class="card-body ">

													<h2 class="text-dark  mt-0 font-weight-bold">{{env('CURRENCY')}} {{$total_price??0}}</h2>
												</div>
											</div>
										</div>
										<div class=" col-sm-12 col-md-6 col-lg-6 col-xl-3"  style="margin-bottom:10px">
											<div class="card overflow-hidden">
												<div class="card-header">
													<h3 class="card-title" style="color:orange">Outstanding (C.M)</h3>
												</div>
												<div class="card-body ">
													<h2 class="text-dark  mt-0 font-weight-bold">{{$outstanding_current??0}}</h2>
												</div>
											</div>
										</div>
										<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 "  style="margin-bottom:10px">
											<div class="card overflow-hidden">
												<div class="card-header">
													<h3 class="card-title" style="color:blue">Outstanding (ALL)</h3>
												</div>
												<div class="card-body ">

													<h2 class="text-dark  mt-0  font-weight-bold">{{env('CURRENCY')}} {{$outstanding??0}}</h2>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-12 col-xl-12">
								<div class="white_shd full margin_bottom_30">
									<div class="full graph_head">
										<div class="heading1 margin_0">
											<h2>Card and Invoices</h2>
										</div>
									</div>
									<div class="full inner_elements">
										<div class="row">
											<div class="col-md-12">
												<div class="tab_style1">
													<div class="tabbar padding_infor_info">
														<nav>
															<div class="nav nav-tabs" id="nav-tab" role="tablist">
															<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Cards</a>
															<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Invoices</a>
															<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Payments</a>
															</div>
														</nav>
														<div class="tab-content" id="nav-tabContent">
															<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
																
																@if(Auth::user()->role == "Masteradmin") 
																<a class="btn btn-info" onclick="openModal()" style="float:right;color:white;margin-bottom:10px">Assign Card</a>
																@endif
																
																<div class="table_section padding_infor_info">
																	<div class="table-responsive-sm" style="overflow-x: hidden;">
																		<table id="example5" class="table table-bordered" style="width:100% !important">
																			<thead>
																				<tr>
																					<th width="20%">Card No</th>
																					<th width="10%">Bank</th>
																					<th width="20%">Card Name</th>
																					<th width="10%">Start Date</th>
																					<th width="10%">End Date</th>
																					<th width="10%">Monthly Price ({{env('CURRENCY')}})</th>
																					<th width="10%">Insurance ({{env('CURRENCY')}})</th>
																					
																					@if(Auth::user()->role == "Masteradmin") 
																					<th width="10%">Actions</th>
																					@endif
																				</tr>
																			</thead>
																			<tbody>
																				@foreach($user->customer_cards as $c)
																				<tr>
																					<td>{{$c->card_no ??''}}</td>
																					<td>{{$c->bank->name ??''}}</td>
																					<td>{{$c->card_name ??''}}</td>
																					<td>{{$c->from_date ??''}}</td>
																					<td>{{$c->to_date ??''}}</td>
																					<td>{{$c->to_price ??''}}</td>
																					<td>{{$c->insurance ??''}}</td>
																					
																					@if(Auth::user()->role == "Masteradmin") 
																					<td>
																						<button class="btn btn-sm btn-info" onclick="editModal({{$c}})">
																						<i class="fa fa-pencil" aria-hidden="true"></i>
																						</button>
																						<button class="btn btn-sm btn-info" onclick="if(confirm('Are you sure you want to delete card from customer?')){ window.location.href='{{ route('customer.removeCard',$c) }}' }">
																							<i class="fa fa-trash" aria-hidden="true"></i>
																						</button>
																					</td>
																					@endif
																				</tr>
																				@endforeach
																			</tbody>
																		</table>

																	</div>
																</div>
															</div>
															<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
																
																	@if(Auth::user()->role == "Masteradmin") 
																<a class="btn btn-info" style="float:right;color:white;margin-bottom:10px" onclick="if(confirm('Are you sure you want to generate invoice?')){ window.location.href='{{ route('customer.generateInvoice',$user) }}' }" >Generate</a>
																@endif
																
																<div class="table_section padding_infor_info">
																	<div class="table-responsive-sm" style="overflow-x: hidden;">
																		<table id="example8" class="table table-bordered" style="width:100% !important">
																		<thead>
																			<tr>
																				<th width="10%">Invoice No</th>
																				<th width="10%">Month Year</th>
																				<th width="10%">Card No</th>
																				<th width="10%">Bank</th>
																				<th width="10%">Card Name</th>
																				<th width="10%">Date From</th>
																				<th width="10%">Date To</th>
																				<th width="10%">No of Days</th>
																				<th width="10%">Total ({{env('CURRENCY')}})</th>
																				@if(Auth::user()->role == "Masteradmin") 
																				<th width="10%">Action</th>
																				@endif
																			</tr>
																		</thead>
																		<tbody>
																			@foreach($user->invoices as $i)
																				@foreach($i->items as $item)
																				<tr>
																					<td>{{$i->invoice_no ??''}}</td>
																					<td><?php echo isset($i->month)?date("F", mktime(0, 0, 0, $i->month, 10)):'' ?> {{$i->year ??''}}</td>
																					<td>{{$item->card->card_no ??''}}</td>
																					<td>{{$item->card->bank->name ??''}}</td>
																					<td>{{$item->card->card_name ??''}}</td>
																					<td>{{$item->date_from ??''}}</td>
																					<td>{{$item->date_to ??''}}</td>
																					<td>{{$item->no_of_days ??''}}</td>
																					<td>{{$item->price ??''}}</td>
																					@if(Auth::user()->role == "Masteradmin") 
																					<td>
																						<button class="btn btn-sm btn-info" onclick="editInvoiceItem({{$item}})">
																							<i class="fa fa-pencil" aria-hidden="true"></i>
																						</button>
																						<button class="btn btn-sm btn-info" onclick="if(confirm('Are you sure you want to delete invoice item?')){ window.location.href='{{ route('customer.destroyItems',$item) }}' }">
																							<i class="fa fa-trash" aria-hidden="true"></i>
																						</button>
																					</td>
																					@endif
																				</tr>
																				@endforeach
																			@endforeach
																		</tbody>
																	</table>
																</div>
																</div>
															</div>
															<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
															@if(Auth::user()->role == "Masteradmin") 
																<a class="btn btn-info" onclick="openPayModal({{$user}})" style="float:right;color:white;margin-bottom:10px">Pay</a>
																@endif
																	<div class="table_section padding_infor_info">
																		<div class="table-responsive-sm" style="overflow-x: hidden;">
																			<table id="example9" class="table table-bordered" style="width:100% !important">
																			<thead>
																				<tr>
																					<th width="20%">Payment Date</th>
																					<th width="20%">Pay for</th>
																					<th width="20%">Amount  ({{env('CURRENCY')}})</th>
																					<th width="20%">Remarks</th>
																					@if(Auth::user()->role == "Masteradmin") 
																					<th width="20%">Action</th>
																					@endif
																				</tr>
																			</thead>
																			<tbody>
																				@foreach($user->payments as $p)
																					<tr>
																						<td>{{$p->pay_date ??''}}</td>
																						<td><?php echo isset($i->month)?date("F", mktime(0, 0, 0, $p->month, 10)):'' ?> {{$p->year ??''}}</td>
																						<td>{{$p->amount ??''}}</td>
																						<td>{{$p->remarks ??''}}</td>
																						@if(Auth::user()->role == "Masteradmin") 
																						<td>
																							<button class="btn btn-sm btn-info" onclick="if(confirm('Are you sure you want to delete payment?')){ window.location.href='{{ route('customer.destroyPayment',$p) }}' }">
																								<i class="fa fa-trash" aria-hidden="true"></i>
																							</button>
																						</td>
																						@endif
																					</tr>
																				@endforeach
																			</tbody>
																		</table>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="largeModal" class="modal fade">
							<div class="modal-dialog modal-md" role="document">
								<div class="modal-content ">
									<div class="modal-header pd-x-20">
										<h4 class="modal-title font-weight-bold">Assign Card</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form enctype="multipart/form-data" method="post" action="{{ route('customer.storeCard',$user) }}">
									@csrf
									<div class="modal-body pd-20">
										<div class="form-group">
											<label class="form-label" for="exampleInputEmail1">Card</label>
											<select class="form-control" name="select_card" id="select_card" required>
												@foreach($card as $c)
													<option value="{{$c->id}}">
														{{$c->card_name??''}} - {{$c->bank->name??''}}
													</option>
												@endforeach
											</select>
										</div>
										<div class="form-group">
											<label class="form-label">Date Start</label>
											<input type="date" class="form-control" name="from_date" id="from_date" required>
										</div>
										<div class="form-group">
											<label class="form-label">Date End</label>
											<input type="date" class="form-control" name="to_date" id="to_date">
										</div>
										<div class="form-group">
											<label class="form-label">Price ({{env('CURRENCY')}})</label>
											<input type="text" class="form-control" name="to_price" id="to_price" required>
										</div>
										<div class="form-group">
											<label class="form-label">Insurance ({{env('CURRENCY')}})</label>
											<input type="text" class="form-control" name="insurance" id="insurance" >
										</div>
									</div><!-- modal-body -->
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary">Save changes</button>
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									</div>
									</form>
								</div>
							</div><!-- modal-dialog -->
						</div>
						<div id="editModal" class="modal fade">
							<div class="modal-dialog modal-md" role="document">
								<div class="modal-content ">
									<div class="modal-header pd-x-20">
										<h4 class="modal-title font-weight-bold" id="title"></h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form enctype="multipart/form-data" method="post" action="{{ route('customer.updateCard') }}">
									@csrf
									<div class="modal-body pd-20">
											<input type="text" class="form-control" name="card_id" id="card_id" required hidden>
										<div class="form-group">
											<label class="form-label">Date Start</label>
											<input type="date" class="form-control" name="edit_from_date" id="edit_from_date" required>
										</div>
										<div class="form-group">
											<label class="form-label">Date End</label>
											<input type="date" class="form-control" name="edit_to_date" id="edit_to_date">
										</div>
										<div class="form-group">
											<label class="form-label">Price ({{env('CURRENCY')}})</label>
											<input type="text" class="form-control" name="edit_to_price" id="edit_to_price" required>
										</div>
										<div class="form-group">
											<label class="form-label">Insurance ({{env('CURRENCY')}})</label>
											<input type="text" class="form-control" name="edit_insurance" id="edit_insurance" >
										</div>
									</div><!-- modal-body -->
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary">Save changes</button>
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									</div>
									</form>
								</div>
							</div><!-- modal-dialog -->
						</div>
						<div id="invoiceItemModal" class="modal fade">
							<div class="modal-dialog modal-md" role="document">
								<div class="modal-content ">
									<div class="modal-header pd-x-20">
										<h4 class="modal-title font-weight-bold" id="title">Edit Invoice Item</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form enctype="multipart/form-data" method="post" action="{{ route('customer.editInvoiceItem') }}">
									@csrf
									<div class="modal-body pd-20">
										<input type="text" class="form-control" name="invoice_item_id" id="invoice_item_id" hidden>
										<div class="form-group">
											<label class="form-label">Date Start</label>
											<input type="date" class="form-control" name="date_from" id="date_from" required>
										</div>
										<div class="form-group">
											<label class="form-label">Date End</label>
											<input type="date" class="form-control" name="date_to" id="date_to" required>
										</div>
										<div class="form-group">
											<label class="form-label">No of days</label>
											<input type="number" class="form-control" name="no_of_days" id="no_of_days" required>
										</div>
										<div class="form-group">
											<label class="form-label">Price ({{env('CURRENCY')}})</label>
											<input type="number" step="0.01" class="form-control" name="price" id="price" required>
										</div>
									</div><!-- modal-body -->
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary">Save changes</button>
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									</div>
									</form>
								</div>
							</div><!-- modal-dialog -->
						</div>
						<div id="payModal" class="modal fade">
							<div class="modal-dialog modal-md" role="document">
								<div class="modal-content ">
									<div class="modal-header pd-x-20">
										<h4 class="modal-title font-weight-bold" id="title">Edit Invoice Item</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form enctype="multipart/form-data" method="post" action="{{ route('customer.pay_receive') }}">
									@csrf
									<div class="modal-body pd-20">
										<input type="text" class="form-control" name="customer_id" id="customer_id" hidden>
										<div class="form-group">
											<label class="form-label">Payment Date</label>
											<input type="date" class="form-control" name="pay_date" id="pay_date" required>
										</div>
										<div class="form-group">
											<label class="form-label">Pay For</label>
											<input type="month" class="form-control" name="pay_for" id="pay_for" required>
										</div>
										<div class="form-group">
											<label class="form-label">Amount Pay ({{env('CURRENCY')}})</label>
											<input type="number" step="0.01" class="form-control" name="amount" id="amount" required>
										</div>
									</div><!-- modal-body -->
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary">Save changes</button>
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									</div>
									</form>
								</div>
							</div><!-- modal-dialog -->
						</div>
			
			<script>
				function openModal(){
    				$("#largeModal").modal();
				}

				function editModal(data){
					console.log(data);
    				$("#editModal").modal();
					document.getElementById("title").innerHTML = "Edit "+data.card_no;
					document.getElementById("card_id").value=data.id;
					document.getElementById("edit_from_date").value=data.from_date;
					document.getElementById("edit_to_date").value=data.to_date;
					document.getElementById("edit_to_price").value=data.to_price;
					document.getElementById("edit_insurance").value=data.insurance;
				}

				function editInvoiceItem(data){
    				$("#invoiceItemModal").modal();
					document.getElementById("invoice_item_id").value=data.id;
					document.getElementById("date_from").value=data.date_from;
					document.getElementById("date_to").value=data.date_to;
					document.getElementById("no_of_days").value=data.no_of_days;
					document.getElementById("price").value=data.price;
				}

				
				function openPayModal(data){
    				$("#payModal").modal();
					document.getElementById("customer_id").value=data.id;
				}

			</script>
@endsection
