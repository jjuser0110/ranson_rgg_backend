@extends('layouts.app')

@section('content')
						<div class="page-header">
							<h4 class="page-title">Announcement</h4>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#"></a>Announcement Details</li>
								<li class="breadcrumb-item active" aria-current="page">announcements</li>
							</ol>

						</div>
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Table List</div>
										
										<a class="btn btn-primary" onclick="openModal()" style="float:right;color:white">Create</a>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example2" class="hover table-bordered border-top-0 border-bottom-0" >
												<thead>
													<tr>
														<th>Announcement Name</th>
														<th>Is Active</th>
														<th></th>
													</tr>
												</thead>
												<tbody>
														@foreach($announcement as $u)
													<tr>
														<td>{{$u->announcement??''}}</td>
														<td><?php echo $u->is_active==1?'Active':'' ?></td>
														<td>
														@if($u->is_active != 1)
														<button class="btn btn-sm btn-success" onclick="if(confirm('Are you sure you want to active this announcement?')){ window.location.href='{{ route('announcement.setActive',$u) }}' }">
															Active
														</button>
														@endif
														@if($u->is_active == 1)
														<button class="btn btn-sm btn-primary" onclick="if(confirm('Are you sure you want to active this announcement?')){ window.location.href='{{ route('announcement.setInActive',$u) }}' }">
															InActive
														</button>
														@endif
														<button class="btn btn-sm btn-info" onclick="editModal({{$u}})">
															Edit
														</button>
														<button class="btn btn-sm btn-info" onclick="if(confirm('Are you sure you want to delete?')){ window.location.href='{{ route('announcement.destroy',$u) }}' }">
															Delete
														</button>
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
							<h4 class="modal-title font-weight-bold">Create Announcement</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form enctype="multipart/form-data" method="post" action="{{ route('announcement.store') }}">
              			@csrf
						<div class="modal-body pd-20">
							<div class="form-group">
								<input type="text" class="form-control" name="announcement_id" id="announcement_id" hidden>
								<label class="form-label" for="exampleInputEmail1">Announcement</label>
								<textarea class="form-control" name="announcement" id="announcement"  required></textarea>
							</div>
						</div><!-- modal-body -->
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Save changes</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div><!-- modal-dialog -->
			</div>

			<script>
				function openModal(){
					
    				$("#largeModal").modal();
					document.getElementById("announcement_id").value='';
					document.getElementById("announcement").value='';
				}

				function editModal(data){
					
    				$("#largeModal").modal();
					document.getElementById("announcement_id").value=data.id;
					document.getElementById("announcement").value=data.announcement;
				}
			</script>
@endsection
