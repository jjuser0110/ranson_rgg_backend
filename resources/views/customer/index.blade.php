@extends('layouts.app')

@section('content')
							
					<div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Customer</h2>
                           </div>
                        </div>
                     </div>
                     <div class="row column1">
							<div class="col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Table List</div>
										
										@if(Auth::user()->role == "Masteradmin") 
										<a class="btn btn-primary" onclick="openModal()" style="float:right;color:white">Create</a>
										@endif
									</div>
									<div class="card-body">
										<div class="table_section padding_infor_info">
											<div class="table-responsive-sm" style="overflow-x: hidden;">
												<table id="example3" class="table table-bordered " style="width:100%">
												<thead>
													<tr>
														<th width="20%">Username</th>
														<th width="20%">Name</th>
														<th width="20%">Contact</th>
														<th width="20%">Status</th>
														<th width="20%">Actions</th>
													</tr>
												</thead>
												<tbody>
														@foreach($user as $u)
													<tr>
														<td>{{$u->username??''}}</td>
														<td>{{$u->name??''}}</td>
														<td>{{$u->contact_no??''}}</td>
														<td><?php echo $u->is_active == 1?'<div class="btn btn-sm" style="background-color:green;color:white">Active</div>':'<div class="btn btn-sm" style="background-color:red;color:white">Inactive</div>' ?></td>
														<td>
														<button class="btn btn-sm btn-info" onclick="window.location.href='{{ route('customer.view',$u) }}' ">
														<i class="fa fa-eye" aria-hidden="true"></i>
														</button>
														
														@if(Auth::user()->role == "Masteradmin") 
														<button class="btn btn-sm btn-info" onclick="editModal({{$u}})">
														<i class="fa fa-pencil" aria-hidden="true"></i>
														</button>
														@endif
														<!-- <button class="btn btn-sm btn-info" onclick="if(confirm('Are you sure you want to reset password?')){ window.location.href='{{ route('user.resetPassword',$u) }}' }">
															Reset Pass
														</button> -->
														<!-- @if($u->is_active == 1)
														<button class="btn btn-sm btn-info" onclick="if(confirm('Are you sure you want to inactive user?')){ window.location.href='{{ route('user.setInactive',$u) }}' }">Inactive</button>
														@else
														<button class="btn btn-sm btn-info" onclick="if(confirm('Are you sure you want to active user?')){ window.location.href='{{ route('user.setActive',$u) }}' }">Active</button>
														@endif -->
															
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
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content ">
						<div class="modal-header pd-x-20">
							<h4 class="modal-title font-weight-bold">Create Customer</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form enctype="multipart/form-data" method="post" action="{{ route('user.store') }}">
              			@csrf
						<div class="modal-body pd-20">
							<div class="form-group">
								<input type="text" class="form-control" name="user_id" id="user_id" hidden>
								<input type="text" class="form-control" name="role" id="role" value="Customer" hidden>
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
							<div class="form-group">
								<label class="form-label" for="exampleInputEmail1">Is Active?</label>
								<select class="form-control" name="is_active" id="is_active">
									<option value=1>Active</option>
									<option value=0>Not Active</option>
								</select>
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
					document.getElementById("user_id").value='';
					document.getElementById("role").value='Customer';
					document.getElementById("username").value='';
					document.getElementById("username").readOnly =false;
					document.getElementById("name").value='';
					document.getElementById("contact_no").value='';
					document.getElementById("is_active").value=1;
				}
				function editModal(data){
					
    				$("#largeModal").modal();
					document.getElementById("user_id").value=data.id;
					document.getElementById("role").value=data.role;
					document.getElementById("username").value=data.username;
					document.getElementById("username").readOnly =true;
					document.getElementById("name").value=data.name;
					document.getElementById("contact_no").value=data.contact_no;
					document.getElementById("is_active").value=data.is_active;
				}
			</script>
@endsection
