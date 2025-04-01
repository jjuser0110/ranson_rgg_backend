@extends('layouts.app')

@section('content')
						<div class="page-header">
							<h4 class="page-title">Card</h4>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#"></a>Card Details</li>
								<li class="breadcrumb-item active" aria-current="page">cards</li>
							</ol>

						</div>
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Table List</div>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
												<div class="card overflow-hidden">
													<div class="card-header">
														<h3 class="card-title" style="color:red">Total Cards</h3>
													</div>
													<div class="card-body ">
														<h2 class="text-dark  mt-0 font-weight-bold">{{$count??0}}</h2>
													</div>
												</div>
											</div>
											<div class=" col-sm-12 col-md-6 col-lg-6 col-xl-3">
												<div class="card overflow-hidden">
													<div class="card-header">
														<h3 class="card-title" style="color:purple">Total Cost</h3>
													</div>
													<div class="card-body ">

														<h2 class="text-dark  mt-0 font-weight-bold">{{env('CURRENCY')}} {{$cost??0}}</h2>
													</div>
												</div>
											</div>
											<div class=" col-sm-12 col-md-6 col-lg-6 col-xl-3">
												<div class="card overflow-hidden">
													<div class="card-header">
														<h3 class="card-title" style="color:orange">Approved Cards</h3>
													</div>
													<div class="card-body ">
														<h2 class="text-dark  mt-0 font-weight-bold">{{$approve_count??0}}</h2>
													</div>
												</div>
											</div>
											<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
												<div class="card overflow-hidden">
													<div class="card-header">
														<h3 class="card-title" style="color:blue">Approved Cost</h3>
													</div>
													<div class="card-body ">

														<h2 class="text-dark  mt-0  font-weight-bold">{{env('CURRENCY')}} {{$approve_cost??0}}</h2>
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-12 col-xl-12">
											<div class="card">
												<div class="card-header">
													<h3 class="card-title">Status</h3>

												</div>
												<div class="card-body p-6">
													<div class="panel panel-primary">
														<div class="tab-menu-heading">
															<div class="tabs-menu ">
																<!-- Tabs -->
																<ul class="nav panel-tabs">
																	<li class=""><a href="#tab1" class="active" data-toggle="tab">Waiting Approval</a></li>
																	<li><a href="#tab2" data-toggle="tab">Rejected</a></li>
																	<li><a href="#tab3" data-toggle="tab">Case</a></li>
																	<li><a href="#tab4" data-toggle="tab">Approved</a></li>
																</ul>
															</div>
														</div>
														<div class="panel-body tabs-menu-body">
															<div class="tab-content">
																<div class="tab-pane active " id="tab1">
																	<div class="table-responsive">
																		<table id="example" class="hover table-bordered border-top-0 border-bottom-0" >
																			<thead>
																				<tr>
																					<th>Card No</th>
																					<th>Bank</th>
																					<th>Card Owner Name</th>
																					<th>Card Owner IC</th>
																					<th>Initial Price ({{env('CURRENCY')}})</th>
																					<th>Monthly Price ({{env('CURRENCY')}})</th>
																					<th>Created By</th>
																					<th>Card Status</th>
																					<th></th>
																				</tr>
																			</thead>
																			<tbody>
																					@foreach($new_card as $u)
																				<tr>
																					<td>{{$u->card_no??''}}</td>
																					<td>{{$u->bank->name??''}}</td>
																					<td>{{$u->card_name??''}}</td>
																					<td>{{$u->ic??''}}</td>
																					<td>{{$u->initial_payment??''}}</td>
																					<td>{{$u->from_price??''}}</td>
																					<td>{{$u->from_user->name??''}}</td>
																					<?php 
																					if($u->is_approved ==1){
																						$status = "<b style='color:green'>Approved</b>";
																					}else if($u->is_approved==2){
																						$status = "<b style='color:red'>Rejected</b>";
																					}else if($u->is_approved==3){
																						$status = "<b style='color:blue'>Case</b>";
																					}else{
																						$status = "<b style='color:orange'>Waiting for Approval</b>";
																					}
																					?>
																					<td><?php echo $status ?></td>
																					<td>
																					<button class="btn btn-sm btn-info" onclick="rentModal({{$u->rent_pay}})">
																						View Rent
																					</button>
																					<button class="btn btn-sm btn-info" onclick="editModal({{$u}})">
																						Edit
																					</button>
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
																					</td>
																				</tr>
																					@endforeach
																			</tbody>
																		</table>

																	</div>
																</div>
																<div class="tab-pane" id="tab2">
																	<div class="table-responsive">
																		<table id="example2" class="hover table-bordered border-top-0 border-bottom-0" >
																			<thead>
																				<tr>
																					<th>Card No</th>
																					<th>Bank</th>
																					<th>Card Owner Name</th>
																					<th>Card Owner IC</th>
																					<th>Initial Price ({{env('CURRENCY')}})</th>
																					<th>Monthly Price ({{env('CURRENCY')}})</th>
																					<th>Created By</th>
																					<th>Card Status</th>
																					<th></th>
																				</tr>
																			</thead>
																			<tbody>
																					@foreach($reject_card as $reject)
																				<tr>
																					<td>{{$reject->card_no??''}}</td>
																					<td>{{$reject->bank->name??''}}</td>
																					<td>{{$reject->card_name??''}}</td>
																					<td>{{$reject->ic??''}}</td>
																					<td>{{$reject->initial_payment??''}}</td>
																					<td>{{$reject->from_price??''}}</td>
																					<td>{{$reject->from_user->name??''}}</td>
																					<?php 
																					if($reject->is_approved ==1){
																						$status = "<b style='color:green'>Approved</b>";
																					}else if($reject->is_approved==2){
																						$status = "<b style='color:red'>Rejected</b>";
																					}else if($reject->is_approved==3){
																						$status = "<b style='color:blue'>Case</b>";
																					}else{
																						$status = "<b style='color:orange'>Waiting for Approval</b>";
																					}
																					?>
																					<td><?php echo $status ?></td>
																					<td>
																					<button class="btn btn-sm btn-info" onclick="rentModal({{$reject->rent_pay}})">
																						View Rent
																					</button>
																					<button class="btn btn-sm btn-info" onclick="editModal({{$reject}})">
																						Edit
																					</button>
																					@if($reject->to_who == null)
																					@if($reject->is_approved != 2)
																					<button class="btn btn-sm btn-info" style="background-color:red" onclick="if(confirm('Are you sure you want to reject this card?')){ window.location.href='{{ route('card.setReject',$reject) }}' }">Reject</button>
																					@endif
																					@if($reject->is_approved != 1)
																					<button class="btn btn-sm btn-info" style="background-color:green" onclick="if(confirm('Are you sure you want to approve this card?')){ approveModal({{$reject}}) }">Approve</button>
																					@endif
																					@if($reject->is_approved != 3)
																					<button class="btn btn-sm btn-info" style="background-color:blue" onclick="if(confirm('Are you sure you want to case this card?')){ window.location.href='{{ route('card.setCase',$reject) }}' }">Case</button>
																					@endif
																					@endif
																					</td>
																				</tr>
																					@endforeach
																			</tbody>
																		</table>

																	</div>
																</div>
																<div class="tab-pane" id="tab3">
																	<div class="table-responsive">
																		<table id="example3" class="hover table-bordered border-top-0 border-bottom-0" >
																			<thead>
																				<tr>
																					<th>Card No</th>
																					<th>Bank</th>
																					<th>Card Owner Name</th>
																					<th>Card Owner IC</th>
																					<th>Initial Price ({{env('CURRENCY')}})</th>
																					<th>Monthly Price ({{env('CURRENCY')}})</th>
																					<th>Created By</th>
																					<th>Card Status</th>
																					<th></th>
																				</tr>
																			</thead>
																			<tbody>
																					@foreach($case_card as $case)
																				<tr>
																					<td>{{$case->card_no??''}}</td>
																					<td>{{$case->bank->name??''}}</td>
																					<td>{{$case->card_name??''}}</td>
																					<td>{{$case->ic??''}}</td>
																					<td>{{$case->initial_payment??''}}</td>
																					<td>{{$case->from_price??''}}</td>
																					<td>{{$case->from_user->name??''}}</td>
																					<?php 
																					if($case->is_approved ==1){
																						$status = "<b style='color:green'>Approved</b>";
																					}else if($case->is_approved==2){
																						$status = "<b style='color:red'>Rejected</b>";
																					}else if($case->is_approved==3){
																						$status = "<b style='color:blue'>Case</b>";
																					}else{
																						$status = "<b style='color:orange'>Waiting for Approval</b>";
																					}
																					?>
																					<td><?php echo $status ?></td>
																					<td>
																					<button class="btn btn-sm btn-info" onclick="rentModal({{$case->rent_pay}})">
																						View Rent
																					</button>
																					<button class="btn btn-sm btn-info" onclick="editModal({{$case}})">
																						Edit
																					</button>
																					@if($case->to_who == null)
																					@if($case->is_approved != 2)
																					<button class="btn btn-sm btn-info" style="background-color:red" onclick="if(confirm('Are you sure you want to reject this card?')){ window.location.href='{{ route('card.setReject',$case) }}' }">Reject</button>
																					@endif
																					@if($case->is_approved != 1)
																					<button class="btn btn-sm btn-info" style="background-color:green" onclick="if(confirm('Are you sure you want to approve this card?')){ approveModal({{$case}}) }">Approve</button>
																					@endif
																					@if($case->is_approved != 3)
																					<button class="btn btn-sm btn-info" style="background-color:blue" onclick="if(confirm('Are you sure you want to case this card?')){ window.location.href='{{ route('card.setCase',$case) }}' }">Case</button>
																					@endif
																					@endif
																					</td>
																				</tr>
																					@endforeach
																			</tbody>
																		</table>

																	</div>
																</div>
																<div class="tab-pane" id="tab4">
																	<div class="table-responsive">
																		<table id="example4" class="hover table-bordered border-top-0 border-bottom-0" >
																			<thead>
																				<tr>
																					<th>Card No</th>
																					<th>Bank</th>
																					<th>Card Owner Name</th>
																					<th>Card Owner IC</th>
																					<th>Initial Price ({{env('CURRENCY')}})</th>
																					<th>Monthly Price ({{env('CURRENCY')}})</th>
																					<th>Created By</th>
																					<th>Card Status</th>
																					<th></th>
																				</tr>
																			</thead>
																			<tbody>
																					@foreach($approve_card as $approve)
																				<tr>
																					<td>{{$approve->card_no??''}}</td>
																					<td>{{$approve->bank->name??''}}</td>
																					<td>{{$approve->card_name??''}}</td>
																					<td>{{$approve->ic??''}}</td>
																					<td>{{$approve->initial_payment??''}}</td>
																					<td>{{$approve->from_price??''}}</td>
																					<td>{{$approve->from_user->name??''}}</td>
																					<?php 
																					if($approve->is_approved ==1){
																						$status = "<b style='color:green'>Approved</b>";
																					}else if($approve->is_approved==2){
																						$status = "<b style='color:red'>Rejected</b>";
																					}else if($approve->is_approved==3){
																						$status = "<b style='color:blue'>Case</b>";
																					}else{
																						$status = "<b style='color:orange'>Waiting for Approval</b>";
																					}
																					?>
																					<td><?php echo $status ?></td>
																					<td>
																					<button class="btn btn-sm btn-info" onclick="rentModal({{$approve->rent_pay}})">
																						View Rent
																					</button>
																					<button class="btn btn-sm btn-info" onclick="editModal({{$approve}})">
																						Edit
																					</button>
																					@if($approve->to_who == null)
																					@if($approve->is_approved != 2)
																					<button class="btn btn-sm btn-info" style="background-color:red" onclick="if(confirm('Are you sure you want to reject this card?')){ window.location.href='{{ route('card.setReject',$approve) }}' }">Reject</button>
																					@endif
																					@if($approve->is_approved != 1)
																					<button class="btn btn-sm btn-info" style="background-color:green" onclick="if(confirm('Are you sure you want to approve this card?')){ approveModal({{$approve}}) }">Approve</button>
																					@endif
																					@if($approve->is_approved != 3)
																					<button class="btn btn-sm btn-info" style="background-color:blue" onclick="if(confirm('Are you sure you want to case this card?')){ window.location.href='{{ route('card.setCase',$approve) }}' }">Case</button>
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
										<label class="form-label" for="exampleInputEmail1">Bank</label>
										<select class="form-control" id="bank_id" name="bank_id" required>
											@foreach($bank as $b)
											<option value="{{$b->id}}">{{$b->name}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Name</label>
										<input type="text" class="form-control" name="card_name" id="card_name"  placeholder="Enter Name" required>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">IC</label>
										<input type="text" class="form-control" name="ic" id="ic"  placeholder="Enter IC" required>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Online User ID</label>
										<input type="text" class="form-control" name="online_user_id" id="online_user_id"  placeholder="..." required>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Online Password</label>
										<input type="text" class="form-control" name="online_password" id="online_password"  placeholder="..." required>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Atm Password</label>
										<input type="text" class="form-control" name="atm_password" id="atm_password"  placeholder="..." required>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Account No</label>
										<input type="text" class="form-control" name="account_no" id="account_no"  placeholder="..." required>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">OTP No</label>
										<input type="text" class="form-control" name="otp_no" id="otp_no"  placeholder="..." required>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Card No/Company ID</label>
										<input type="text" class="form-control" name="card_no" id="card_no"  placeholder="..." required>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Address of Bank</label>
										<input type="text" class="form-control" name="address_of_bank" id="address_of_bank"  placeholder="..." required>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Secure word</label>
										<input type="text" class="form-control" name="secure_word" id="secure_word"  placeholder="..." required>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Gmail of Bank</label>
										<input type="text" class="form-control" name="gmail_of_bank" id="gmail_of_bank"  placeholder="..." required>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Home Address</label>
										<input type="text" class="form-control" name="home_address" id="home_address"  placeholder="..." >
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Mother Name</label>
										<input type="text" class="form-control" name="mother_name" id="mother_name"  placeholder="..." >
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Company Name</label>
										<input type="text" class="form-control" name="token_key" id="token_key"  placeholder="..." >
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Card Cost ({{env('CURRENCY')}})</label>
										<input type="text" class="form-control" name="from_price" id="from_price"  placeholder="..." >
									</div>
								</div>
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
			
			<div id="rentingModal" class="modal fade">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content ">
						<div class="modal-header pd-x-20">
							<h4 class="modal-title font-weight-bold" id="title">Rent Data</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body pd-20">
							<div class="table_section padding_infor_info">
								<div class="table-responsive-sm" style="overflow-x: hidden;">
								<table class="table table-bordered"  style="width:100%">
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
						</div><!-- modal-body -->
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div><!-- modal-dialog -->
			</div>

			<script>
				function openModal(){
					
    				$("#largeModal").modal();
					document.getElementById("card_id").value='';
					document.getElementById("bank_id").value='';
					document.getElementById("card_name").value='';
					document.getElementById("ic").value='';
					document.getElementById("online_user_id").value='';
					document.getElementById("online_password").value='';
					document.getElementById("atm_password").value='';
					document.getElementById("account_no").value='';
					document.getElementById("otp_no").value='';
					document.getElementById("card_no").value='';
					document.getElementById("address_of_bank").value='';
					document.getElementById("secure_word").value='';
					document.getElementById("gmail_of_bank").value='';
					document.getElementById("token_key").value='';
					document.getElementById("from_price").value='';
					document.getElementById("mother_name").value='';
					document.getElementById("home_address").value='';
				}

				function editModal(data){
					
    				$("#largeModal").modal();
					document.getElementById("card_id").value=data.id;
					document.getElementById("bank_id").value=data.bank_id;
					document.getElementById("card_name").value=data.card_name;
					document.getElementById("ic").value=data.ic;
					document.getElementById("online_user_id").value=data.online_user_id;
					document.getElementById("online_password").value=data.online_password;
					document.getElementById("atm_password").value=data.atm_password;
					document.getElementById("account_no").value=data.account_no;
					document.getElementById("otp_no").value=data.otp_no;
					document.getElementById("card_no").value=data.card_no;
					document.getElementById("address_of_bank").value=data.address_of_bank;
					document.getElementById("secure_word").value=data.secure_word;
					document.getElementById("gmail_of_bank").value=data.gmail_of_bank;
					document.getElementById("token_key").value=data.token_key;
					document.getElementById("from_price").value=data.from_price;
					document.getElementById("mother_name").value=data.mother_name;
					document.getElementById("home_address").value=data.home_address;
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
