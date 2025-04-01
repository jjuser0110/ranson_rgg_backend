@extends('layouts.app')

@section('content')
<div class="page-header">
							<h4 class="page-title">{{$user->username}}</h4>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#">{{$user->username}}</a></li>
								<li class="breadcrumb-item active" aria-current="page">Profile</li>
							</ol>

						</div>

						<div class="row">
							<div class="col-lg-5 col-xl-4">
								<div class="card card-profile cover-image "  data-image-src="{{asset('assets/images/photos/gradient3.jpg')}}">
									<div class="card-body text-center">
										<img class="card-profile-img" src="{{asset('assets/images/star.jpg')}}" alt="img">
										<h3 class="mb-1 text-white">{{$user->username??''}}</h3>
									</div>
								</div>
							</div>
							<div class="col-lg-7 col-xl-8">
								<div class="card">
									<div class="card-body">
										<div id="profile-log-switch">
											<div class="fade show active " >
												<div class="table-responsive border ">
													<table class="table row table-borderless w-100 m-0 ">
														<tbody class="col-lg-12 col-xl-6 p-0">
															<tr>
																<td><strong>Name :</strong> {{$user->name??''}}</td>
															</tr>
															<tr>
																<td><strong>Contact No :</strong> {{$user->contact_no??''}}</td>
															</tr>
															<tr>
																<td><strong>Username :</strong> {{$user->username??''}}</td>
															</tr>
														</tbody>
														<tbody class="col-lg-12 col-xl-6 p-0">
															<tr>
																<td><strong>Role :</strong> {{$user->role??''}}</td>
															</tr>
															<tr>
																<td><strong>Upline :</strong> {{$user->upline_dt->name??''}} </td>
															</tr>
															<tr>
																<td><strong>Status :</strong> <?php echo $user->is_active == 1?'<div class="btn btn-sm" style="background-color:green;color:white">Active</div>':'<div class="btn btn-sm" style="background-color:red;color:white">Inactive</div>' ?> </td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>

								
							</div>
							
							<div class="col-lg-12 col-xl-12">
								<div class="card-body">
									<div class="row">
										<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
											<div class="card overflow-hidden">
												<div class="card-header">
													<h3 class="card-title" style="color:red">Total Cards </h3>
												</div>
												<div class="card-body ">
													<h2 class="text-dark  mt-0 font-weight-bold">{{$count??0}}</h2>
												</div>
											</div>
										</div>
										<div class=" col-sm-12 col-md-6 col-lg-6 col-xl-3">
											<div class="card overflow-hidden">
												<div class="card-header">
													<h3 class="card-title" style="color:purple">Total Cost </h3>
												</div>
												<div class="card-body ">

													<h2 class="text-dark  mt-0 font-weight-bold">{{env('CURRENCY')}} {{$cost??0}}</h2>
												</div>
											</div>
										</div>
										<div class=" col-sm-12 col-md-6 col-lg-6 col-xl-3">
											<div class="card overflow-hidden">
												<div class="card-header">
													<h3 class="card-title" style="color:orange">Approved Cards </h3>
												</div>
												<div class="card-body ">
													<h2 class="text-dark  mt-0 font-weight-bold">{{$approve_count??0}}</h2>
												</div>
											</div>
										</div>
										<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
											<div class="card overflow-hidden">
												<div class="card-header">
													<h3 class="card-title" style="color:blue">Approved Cost </h3>
												</div>
												<div class="card-body ">

													<h2 class="text-dark  mt-0  font-weight-bold">{{env('CURRENCY')}} {{$approve_cost??0}}</h2>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php 
								switch ($user->role) {
									case "Superadmins":
									  $title = "Admins";
									  break;
									case "Admins":
									  $title = "Agents";
									  break;
									default:
									  $title = "";
								  }
							?>
							@if($user->role != "Agents")
							<div class="col-lg-12 col-xl-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">{{$title??''}}</h3>

									</div>
									<div class="card-body">
										<div class="table-responsive">
										<table id="example2" class="hover table-bordered border-top-0 border-bottom-0" >
												<thead>
													<tr>
														<th>Username</th>
														<th>Name</th>
														<th>Contact</th>
														<th>Status</th>
														<th></th>
													</tr>
												</thead>
												<tbody>
														@foreach($user->downline as $u)
													<tr>
														<td><a style="color:blue" href="{{route('user.view',$u->id)}}">{{$u->username??''}}</a></td>
														<td>{{$u->name??''}}</td>
														<td>{{$u->contact_no??''}}</td>
														<td><?php echo $u->is_active == 1?'<div class="btn btn-sm" style="background-color:green;color:white">Active</div>':'<div class="btn btn-sm" style="background-color:red;color:white">Inactive</div>' ?></td>
														<td>
														<!-- <button class="btn btn-sm btn-info" onclick="window.location.href='{{ route('user.view',$u) }}' ">
															View
														</button> -->
														@if(Auth::user()->role=="Masteradmin")
														<button class="btn btn-sm btn-info" onclick="editUserModal({{$u}})">
															Edit
														</button>
														<button class="btn btn-sm btn-info" onclick="if(confirm('Are you sure you want to reset password?')){ window.location.href='{{ route('user.resetPassword',$u) }}' }">
															Reset Pass
														</button>
														@if($u->is_active == 1)
														<button class="btn btn-sm btn-info" onclick="if(confirm('Are you sure you want to inactive user?')){ window.location.href='{{ route('user.setInactive',$u) }}' }">Inactive</button>
														@else
														<button class="btn btn-sm btn-info" onclick="if(confirm('Are you sure you want to active user?')){ window.location.href='{{ route('user.setActive',$u) }}' }">Active</button>
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
							@endif
							<div class="col-lg-12 col-xl-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Cards Details</h3>

									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example" class="hover table-bordered border-top-0 border-bottom-0" >
												<thead>
													<tr>
														<th>Card No</th>
														<th>Card Owner Name</th>
														<th>Card Owner IC</th>
														<th>Bank</th>
														<th>Price ({{env('CURRENCY')}})</th>
														<th>Card Status</th>
														<th></th>
													</tr>
												</thead>
												<tbody>
														@foreach($user->cards as $card)
													<tr>
														<td>{{$card->card_no??''}}</td>
														<td>{{$card->card_name??''}}</td>
														<td>{{$card->ic??''}}</td>
														<td>{{$card->bank->name??''}}</td>
														<td>{{$card->cost??''}}</td>
														<?php 
														if($card->is_approved ==1){
															$status = "<b style='color:green'>Approved</b>";
														}else if($card->is_approved==2){
															$status = "<b style='color:red'>Rejected</b>";
														}else if($card->is_approved==3){
															$status = "<b style='color:blue'>Case</b>";
														}else{
															$status = "<b style='color:orange'>Waiting for Approval</b>";
														}
														?>
														<td><?php echo $status ?></td>
														<td>
														<button class="btn btn-sm btn-info" onclick="editModal({{$card}})">
															Edit
														</button>
														@if(Auth::user()->role == "Masteradmin" || Auth::user()->role == "Superadmins")
															@if($card->is_approved == null)
															<button class="btn btn-sm btn-info" style="background-color:green" onclick="if(confirm('Are you sure you want to approve card?')){ approveModal({{$card}}) }">Approve</button>
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
							<div class="row">
								<div class="col-md-6 col-lg-6">
									<input type="text" class="form-control" name="card_id" id="card_id" hidden>
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
							<button type="submit" class="btn btn-primary" id="button_submit">Save changes</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
						</form>
					</div>
				</div><!-- modal-dialog -->
			</div>
			<div id="secondlargeModal" class="modal fade">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content ">
						<div class="modal-header pd-x-20">
							<h4 class="modal-title font-weight-bold">Create {{$title}}</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form enctype="multipart/form-data" method="post" action="{{ route('user.store') }}">
              			@csrf
						<div class="modal-body pd-20">
							<div class="form-group">
								<input type="text" class="form-control" name="user_id" id="user_id" hidden>
								<input type="text" class="form-control" name="role" id="role" value="{{$title}}" hidden>
								<label class="form-label" for="exampleInputEmail1">Username</label>
								<input type="text" class="form-control" name="username" id="username"  placeholder="Enter Username" required>
							</div>
							<div class="form-group">
								<label class="form-label" for="exampleInputEmail1">Name</label>
								<input type="text" class="form-control" name="name" id="name"  placeholder="Enter Name" required>
							</div>
							<div class="form-group">
								<label class="form-label" for="exampleInputEmail1">Contact No</label>
								<input type="text" class="form-control" name="contact_no" id="contact_no"  placeholder="Enter Contact No" required>
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
			<script>
				function editModal(data){
					console.log(data);
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
					if(data.is_approved == 1){
						document.getElementById("bank_id").disabled=true;
						document.getElementById("card_name").readOnly=true;
						document.getElementById("ic").readOnly=true;
						document.getElementById("online_user_id").readOnly=true;
						document.getElementById("online_password").readOnly=true;
						document.getElementById("atm_password").readOnly=true;
						document.getElementById("account_no").readOnly=true;
						document.getElementById("otp_no").readOnly=true;
						document.getElementById("card_no").readOnly=true;
						document.getElementById("address_of_bank").readOnly=true;
						document.getElementById("secure_word").readOnly=true;
						document.getElementById("gmail_of_bank").readOnly=true;
						document.getElementById("token_key").readOnly=true;
						document.getElementById("from_price").readOnly=true;
						document.getElementById("button_submit").hidden=true;
						document.getElementById("mother_name").readOnly=true;
						document.getElementById("home_address").readOnly=true;
					}
				}

				function editUserModal(data){
    				$("#secondlargeModal").modal();
					document.getElementById("user_id").value=data.id;
					document.getElementById("role").value=data.role;
					document.getElementById("username").value=data.username;
					document.getElementById("username").readOnly =true;
					document.getElementById("name").value=data.name;
					document.getElementById("contact_no").value=data.contact_no;
				
				}
				

				function approveModal(data){
    				$("#approveModal").modal();
					document.getElementById("card_idd").value=data.id;
					document.getElementById("monthly_cost").value=data.from_price;
				}
			</script>
@endsection
