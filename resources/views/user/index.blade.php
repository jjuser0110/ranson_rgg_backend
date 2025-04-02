@extends('layouts.app')

@section('content')
<div class="page-header">
	<h4 class="page-title">User</h4>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="#"></a>Users</li>
	</ol>

</div>
<div class="row">
	<div class="col-md-12 col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="card-title">Table List</div>

				@if(Auth::user()->username == "admin")
				<a class="btn btn-primary" onclick="openModal()" style="float:right;color:white">Create</a>
				@endif
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example2" class="hover table-bordered border-top-0 border-bottom-0" >
						<thead>
							<tr>
								<th>Username</th>
                                <th>User ID</th>
                                <th>Name</th>
								<th>Email</th>
								<th>Status</th>
								@if(Auth::user()->username == "admin")
								<th>Actions</th>
								@endif
							</tr>
						</thead>
						<tbody>
								@foreach($users as $u)
							<tr>
								<td>{{$u->username??''}}</td>
                                <td>{{$u->userid??''}}</td>
                                <td>{{$u->name??''}}</td>
								<td>{{$u->email??''}}</td>
								<td>
                                    @if ($u->is_active)
                                        <div class="btn btn-sm" style="background-color:green;color:white" onclick="if(confirm('Are you sure you want to inactive this user?')){ window.location.href='{{ route('user.setInactive',$u) }}' }">Active</div>
                                    @else
                                        <div class="btn btn-sm" style="background-color:green;color:white" onclick="if(confirm('Are you sure you want to active this user?')){ window.location.href='{{ route('user.setActive',$u) }}' }">Inactive</div>
                                    @endif
                                </td>
								@if(Auth::user()->username == "admin")
								<td>
								<button class="btn btn-sm btn-info" onclick="editModal({{$u}})">
									Edit
								</button>
								<button class="btn btn-sm btn-info" onclick="if(confirm('Are you sure you want to reset password to 123456789?')){ window.location.href='{{ route('user.resetPassword',$u) }}' }">
									Reset Pass
								</button>
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
				<h4 class="modal-title font-weight-bold">Create User</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form enctype="multipart/form-data" method="post" action="{{ route('user.store') }}">
			@csrf
			<div class="modal-body pd-20">
				<div class="form-group">
					<input type="text" class="form-control" name="user_id" id="user_id" hidden>
					<label class="form-label" for="exampleInputEmail1">Username</label>
					<input type="text" class="form-control" name="username" id="username"  placeholder="Enter Username" required>
				</div>
                <div class="form-group">
					<label class="form-label" for="exampleInputEmail1">User ID</label>
					<input type="text" class="form-control" name="userid" id="userid"  placeholder="Enter User  ID" required>
				</div>
                <div class="form-group">
					<label class="form-label" for="exampleInputEmail1">Name</label>
					<input type="text" class="form-control" name="name" id="name"  placeholder="Enter Name" required>
				</div>
				<div class="form-group">
					<label class="form-label" for="exampleInputEmail1">Email</label>
					<input type="text" class="form-control" name="email" id="email"  placeholder="Enter Email" required>
				</div>
				<div class="form-group">
					<label class="form-label" for="exampleInputEmail1">Password</label>
					<input type="text" class="form-control" name="password" id="password"  placeholder="Password" required>
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
		document.getElementById("username").value='';
        document.getElementById("userid").value='';
        document.getElementById("name").value='';
		document.getElementById("email").value='';
		document.getElementById("password").style.display = "block";
		document.getElementById("password").value='';

	}
	function editModal(data){

		$("#largeModal").modal();
		document.getElementById("user_id").value=data.id;
		document.getElementById("username").value=data.username;
        document.getElementById("userid").value=data.userid;
        document.getElementById("name").value=data.name;
		document.getElementById("email").value=data.email;
		document.getElementById("password").style.display = "none";
		document.getElementById("password").required=false;

	}
</script>
@endsection
