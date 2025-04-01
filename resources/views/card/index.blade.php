@extends('layouts.app')

@section('content')
					<div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Card Details</h2>
                           </div>
                        </div>
                     </div>
                     <div class="row column1">
							<div class="col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Table List</div>
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
										@if(Auth::user()->role == "Masteradmin")
										<a class="btn btn-primary" onclick="openModal()" style="float:right;color:white">Create</a>
										@endif
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3  " style="margin-bottom:10px">
												<div class="card overflow-hidden">
													<div class="card-header">
														<h3 class="card-title" style="color:blue">Total Card</h3>
													</div>
													<div class="card-body ">

														<h2 class="text-dark  mt-0  font-weight-bold">{{$card->count()??0}}</h2>
													</div>
												</div>
											</div>
											<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 " style="margin-bottom:10px">
												<div class="card overflow-hidden">
													<div class="card-header">
														<h3 class="card-title" style="color:red">Approved Card</h3>
													</div>
													<div class="card-body ">
														<h2 class="text-dark  mt-0 font-weight-bold">{{$approve_count??0}}</h2>
													</div>
												</div>
											</div>
											<div class=" col-sm-12 col-md-6 col-lg-6 col-xl-3" style="margin-bottom:10px">
												<div class="card overflow-hidden">
													<div class="card-header">
														<h3 class="card-title" style="color:orange">Rent Card</h3>
													</div>
													<div class="card-body ">
														<h2 class="text-dark  mt-0 font-weight-bold">{{$rent_count??0}}</h2>
													</div>
												</div>
											</div>
											<div class=" col-sm-12 col-md-6 col-lg-6 col-xl-3" style="margin-bottom:10px">
												<div class="card overflow-hidden">
													<div class="card-header">
														<h3 class="card-title" style="color:purple">Rent Cost</h3>
													</div>
													<div class="card-body ">

														<h2 class="text-dark  mt-0 font-weight-bold">{{env('CURRENCY')}} {{$rent_cost??0}}</h2>
													</div>
												</div>
											</div>
										</div>
										<div class="table_section padding_infor_info">
											<div class="table-responsive-sm" style="overflow-x: hidden;">
												<table id="example2" class="table table-bordered" style="width:100%">
												<thead>
													<tr>
														<th width="15%">Card No</th>
														<th width="15%">Card Owner Name</th>
														<th width="15%">Card Owner IC</th>
														<th width="15%">Bank</th>
														<th width="10%">Price ({{env('CURRENCY')}})</th>
														<th width="10%">Card Status</th>
														<th width="10%">Agent</th>
														<th width="10%">This Month Rent</th>
														<th width="10%">Actions</th>
													</tr>
												</thead>
												<tbody>
														@foreach($card as $u)
													<tr>
														<td>{{$u->card_no??''}}</td>
														<td>{{$u->card_name??''}}</td>
														<td>{{$u->ic??''}}</td>
														<td>{{$u->bank->name??''}}</td>
														<td>{{$u->cost??''}}</td>
														<?php 
														if($u->is_approved ==1){
															$status = "<b style='color:green' title='".$u->remarks."'>Approved</b>";
														}else if($u->is_approved==2){
															$status = "<b style='color:red' title='".$u->remarks."'>Rejected</b>";
														}else if($u->is_approved==3){
															$status = "<b style='color:blue' title='".$u->remarks."'>Case</b>";
														}else{
															$status = "<b style='color:orange'>Waiting for Approval</b>";
														}
														?>
														<td><?php echo $status ?></td>
														<td>{{$u->agentdetail->username??''}}</td>
														<td>{{$u->rent_pay->where('year',$year)->where('month',$month)->first()->price??''}}</td>
														<td>
														<button class="btn btn-sm btn-info" onclick="window.location.href='{{ route('card.view_rent',$u) }}'">
														<i class="fa fa-eye" aria-hidden="true"></i>
														</button>
														<button class="btn btn-sm btn-info" onclick="editModal({{$u}})">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</button>
														
														@if(Auth::user()->role == "Masteradmin")
														@if($u->to_who == null)
														@if($u->is_approved != 2)
														<button class="btn btn-sm btn-info" style="background-color:red" onclick="if(confirm('Are you sure you want to reject this card?')){ window.location.href='{{ route('card.setReject',$u) }}' }">Reject</button>
														@endif
														@if($u->is_approved != 1)
														<button class="btn btn-sm btn-info" style="background-color:green" onclick="if(confirm('Are you sure you want to approve this card?')){ approveModal({{$u}}) }">Approve</button>
														@endif
														@if($u->is_approved != 3)
														<button class="btn btn-sm btn-info" style="background-color:blue" onclick="if(confirm('Are you sure you want to case this card?')){ window.location.href='{{ route('card.setCase',$u) }}' }">Case</button>
														@endif
														@endif
														@endif
														</td>
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
			<div id="largeModal" class="modal fade">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content ">
						<div class="modal-header pd-x-20">
							<h4 class="modal-title font-weight-bold">Create Card</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form enctype="multipart/form-data" method="post" action="{{ route('card.store') }}">
              			@csrf
						<div class="modal-body pd-20">
							<input type="text" class="form-control" name="card_id" id="card_id" hidden>
							<div class="row">
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Agent</label>
										<select class="form-control" id="user_id" name="user_id" required @if(Auth::user()->role != "Masteradmin") echo disabled @endif>
											@foreach($agent as $a)
											<option value="{{$a->id}}">{{$a->username}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Bank</label>
										<select class="form-control" id="bank_id" name="bank_id" required @if(Auth::user()->role != "Masteradmin") echo disabled @endif>
											@foreach($bank as $b)
											<option value="{{$b->id}}">{{$b->name}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Name</label>
										<input type="text" class="form-control" name="card_name" id="card_name"  placeholder="Enter Name" required @if(Auth::user()->role != "Masteradmin") echo readonly @endif>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">IC</label>
										<input type="text" class="form-control" name="ic" id="ic"  placeholder="Enter IC" required  @if(Auth::user()->role != "Masteradmin") echo readonly @endif>
									</div>
								</div>
								<!-- <div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Online User ID</label>
										<input type="text" class="form-control" name="online_user_id" id="online_user_id"  placeholder="..." required  @if(Auth::user()->role != "Masteradmin") echo readonly @endif>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Online Password</label>
										<input type="text" class="form-control" name="online_password" id="online_password"  placeholder="..." required  @if(Auth::user()->role != "Masteradmin") echo readonly @endif>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Atm Password</label>
										<input type="text" class="form-control" name="atm_password" id="atm_password"  placeholder="..." required  @if(Auth::user()->role != "Masteradmin") echo readonly @endif>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Account No</label>
										<input type="text" class="form-control" name="account_no" id="account_no"  placeholder="..." required  @if(Auth::user()->role != "Masteradmin") echo readonly @endif>
									</div>
								</div> -->
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Card No/Company ID</label>
										<input type="text" class="form-control" name="card_no" id="card_no"  placeholder="..." required  @if(Auth::user()->role != "Masteradmin") echo readonly @endif>
									</div>
								</div>
								<!-- <div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Address of Bank</label>
										<input type="text" class="form-control" name="address_of_bank" id="address_of_bank"  placeholder="..."  required @if(Auth::user()->role != "Masteradmin") echo readonly @endif>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Secure word</label>
										<input type="text" class="form-control" name="secure_word" id="secure_word"  placeholder="..."  required @if(Auth::user()->role != "Masteradmin") echo readonly @endif>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Gmail of Bank</label>
										<input type="text" class="form-control" name="gmail_of_bank" id="gmail_of_bank"  placeholder="..."  required @if(Auth::user()->role != "Masteradmin") echo readonly @endif>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Home Address</label>
										<input type="text" class="form-control" name="home_address" id="home_address"  placeholder="..."  @if(Auth::user()->role != "Masteradmin") echo readonly @endif>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Mother Name</label>
										<input type="text" class="form-control" name="mother_name" id="mother_name"  placeholder="..."  @if(Auth::user()->role != "Masteradmin") echo readonly @endif>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Company Name</label>
										<input type="text" class="form-control" name="token_key" id="token_key"  placeholder="..."  @if(Auth::user()->role != "Masteradmin") echo readonly @endif>
									</div>
								</div> -->
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Card Cost ({{env('CURRENCY')}})</label>
										<input type="text" class="form-control" name="from_price" id="from_price"  placeholder="..."  @if(Auth::user()->role != "Masteradmin") echo readonly @endif>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">OTP No</label>
										<input type="text" class="form-control" name="otp_no" id="otp_no"  placeholder="..." required  @if(Auth::user()->role != "Masteradmin") echo readonly @endif>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Expired Date</label>
										<input type="date" class="form-control" name="expired_date" id="expired_date"  placeholder="..."  @if(Auth::user()->role != "Masteradmin") echo readonly @endif>
									</div>
								</div>
								<div class="col-md-12 col-lg-12">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Details</label>
										<textarea class="form-control" rows="10" name="details" id="details" required  @if(Auth::user()->role != "Masteradmin") echo readonly @endif></textarea>
									</div>
								</div>
								<!-- <div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Remarks</label>
										<input type="text" class="form-control" name="remarks" id="remarks"  placeholder="..."  @if(Auth::user()->role != "Masteradmin") echo readonly @endif>
									</div>
								</div> -->
							</div>
						</div><!-- modal-body -->
						<div class="modal-footer">
						@if(Auth::user()->role == "Masteradmin") 
							<button type="submit" class="btn btn-primary">Save changes</button>
							@endif
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
						</form>
					</div>
				</div><!-- modal-dialog -->
			</div>
			<div id="approveModal" class="modal fade">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content ">
						<div class="modal-header pd-x-20">
							<h4 class="modal-title font-weight-bold" id="title">Approve Card</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form enctype="multipart/form-data" method="post" action="{{ route('card.setApprove') }}">
						@csrf
						<div class="modal-body pd-20">
							<input type="text" class="form-control" name="card_idd" id="card_idd" hidden>
							<div class="form-group">
								<label class="form-label">Initial Cost ({{env('CURRENCY')}})</label>
								<input type="number" step="0.01" class="form-control" name="initial_cost" id="initial_cost" required>
							</div>
							<div class="form-group">
								<label class="form-label">Monthly Cost ({{env('CURRENCY')}})</label>
								<input type="number" step="0.01" class="form-control" name="monthly_cost" id="monthly_cost" required>
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
			
			<!-- <div id="rentingModal" class="modal fade">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content ">
						<div class="modal-header pd-x-20">
							<h4 class="modal-title font-weight-bold" id="title">Rent Data</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body pd-20">
							<div class="table-responsive">
								<table id="example8" >
									<thead>
										<tr>
											<th>Month ~ Year</th>
											<th>Amount  ({{env('CURRENCY')}})</th>
										</tr>
									</thead>
									<tbody id="items_details">
									</tbody>
								</table>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div> -->

			<script>
				function openModal(){
					
    				$("#largeModal").modal();
					document.getElementById("user_id").value='';
					document.getElementById("card_id").value='';
					document.getElementById("bank_id").value='';
					document.getElementById("card_name").value='';
					document.getElementById("ic").value='';
					// document.getElementById("online_user_id").value='';
					// document.getElementById("online_password").value='';
					// document.getElementById("atm_password").value='';
					// document.getElementById("account_no").value='';
					document.getElementById("otp_no").value='';
					document.getElementById("card_no").value='';
					// document.getElementById("address_of_bank").value='';
					// document.getElementById("secure_word").value='';
					// document.getElementById("gmail_of_bank").value='';
					// document.getElementById("token_key").value='';
					document.getElementById("from_price").value='';
					document.getElementById("expired_date").value='';
					document.getElementById("details").value='';
					// document.getElementById("mother_name").value='';
					// document.getElementById("home_address").value='';
					// document.getElementById("remarks").value='';
				}

				function editModal(data){
					
    				$("#largeModal").modal();
					document.getElementById("card_id").value=data.id;
					document.getElementById("user_id").value=data.user_id;
					document.getElementById("bank_id").value=data.bank_id;
					document.getElementById("card_name").value=data.card_name;
					document.getElementById("ic").value=data.ic;
					// document.getElementById("online_user_id").value=data.online_user_id;
					// document.getElementById("online_password").value=data.online_password;
					// document.getElementById("atm_password").value=data.atm_password;
					// document.getElementById("account_no").value=data.account_no;
					document.getElementById("otp_no").value=data.otp_no;
					document.getElementById("card_no").value=data.card_no;
					// document.getElementById("address_of_bank").value=data.address_of_bank;
					// document.getElementById("secure_word").value=data.secure_word;
					// document.getElementById("gmail_of_bank").value=data.gmail_of_bank;
					// document.getElementById("token_key").value=data.token_key;
					document.getElementById("from_price").value=data.from_price;
					document.getElementById("expired_date").value=data.expired_date;
					document.getElementById("details").value=data.details;
					// document.getElementById("mother_name").value=data.mother_name;
					// document.getElementById("home_address").value=data.home_address;
					// document.getElementById("remarks").value=data.remarks;
				}

				
				function approveModal(data){
    				$("#approveModal").modal();
					document.getElementById("card_idd").value=data.id;
					document.getElementById("monthly_cost").value=data.from_price;
				}

				

				function rentModal(data){
    				$("#rentingModal").modal();
					
					$('#items_details').empty();
					data.forEach(function(row) {
						$('#items_details').append('<tr><td>'+toMonthName(row.month)+' '+row.year+'</td><td>'+row.amount+'</td></tr>');
					});
				}
				

				function toMonthName(monthNumber) {
					const date = new Date();
					date.setMonth(monthNumber - 1);

					return date.toLocaleString('en-US', {
						month: 'long',
					});
				}
			</script>
@endsection
