@extends('layouts.app')

@section('content')
						<div class="page-header">
							<h4 class="page-title">{{$role??''}}</h4>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#"></a>User Settings</li>
								<li class="breadcrumb-item active" aria-current="page">{{$role??''}}</li>
							</ol>

						</div>
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Table List</div>
										
										<!-- <a class="btn btn-primary" onclick="openModal('{{$role}}')" style="float:right;color:white">Create</a> -->
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example2" class="hover table-bordered border-top-0 border-bottom-0" >
												<thead>
													<tr>
														<th>Username</th>
														<th>Name</th>
														<th>Contact</th>
														<th>Total Cards</th>
														<th>Total Costs ({{env('CURRENCY')}})</th>
														<th>Approved Cards</th>
														<th>Approved Costs ({{env('CURRENCY')}})</th>
														<th>Status</th>
														<th></th>
													</tr>
												</thead>
												<tbody>
														@foreach($users as $u)
													<tr>
														<td>{{$u->username??''}}</td>
														<td>{{$u->name??''}}</td>
														<td>{{$u->contact_no??''}}</td>
														<td>{{$u->u_count??0}}</td>
														<td>{{$u->u_cost??0}}</td>
														<td>{{$u->u_approve_count??0}}</td>
														<td>{{$u->u_approve_cost??0}}</td>
														<td><?php echo $u->is_active == 1?'<div class="btn btn-sm" style="background-color:green;color:white">Active</div>':'<div class="btn btn-sm" style="background-color:red;color:white">Inactive</div>' ?></td>
														<td>
														<!-- <button class="btn btn-sm btn-info" onclick="window.location.href='{{ route('user.view',$u) }}' ">
															View
														</button> -->
														<button class="btn btn-sm btn-info" onclick="editModal({{$u}})">
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
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content ">
						<div class="modal-header pd-x-20">
							<h4 class="modal-title font-weight-bold">Create {{$role}}</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form enctype="multipart/form-data" method="post" action="{{ route('user.store') }}">
              			@csrf
						<div class="modal-body pd-20">
							<div class="form-group">
								<input type="text" class="form-control" name="user_id" id="user_id" hidden>
								<input type="text" class="form-control" name="role" id="role" value="{{$role}}" hidden>
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

			<script>
				function openModal(role){
					
    				$("#largeModal").modal();
					document.getElementById("user_id").value='';
					document.getElementById("role").value=role;
					document.getElementById("username").value='';
					document.getElementById("username").readOnly =false;
					document.getElementById("name").value='';
					document.getElementById("contact_no").value='';
				}
				function editModal(data){
					
    				$("#largeModal").modal();
					document.getElementById("user_id").value=data.id;
					document.getElementById("role").value=data.role;
					document.getElementById("username").value=data.username;
					document.getElementById("username").readOnly =true;
					document.getElementById("name").value=data.name;
					document.getElementById("contact_no").value=data.contact_no;
				}
			</script>
@endsection
