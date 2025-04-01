@extends('layouts.app')

@section('content')
<div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Bank Details</h2>
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
												<table id="example2" class="table table-bordered " style="width:100%">
									<thead>
										<tr>
											<th width="50%">Bank Name</th>
											@if(Auth::user()->role == "Masteradmin")
											<th width="50%">Actions</th>
											@endif
										</tr>
									</thead>
									<tbody>
											@foreach($bank as $u)
										<tr>
											<td>{{$u->name??''}}</td>
											@if(Auth::user()->role == "Masteradmin")
											<td>
											<button class="btn btn-sm btn-info" onclick="editModal({{$u}})">
												
											<i class="fa fa-pencil" aria-hidden="true"></i>
											</button>
											<button class="btn btn-sm btn-info" onclick="if(confirm('Are you sure you want to delete?')){ window.location.href='{{ route('bank.destroy',$u) }}' }">
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
			<div id="largeModal" class="modal fade">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content ">
						<div class="modal-header pd-x-20">
							<h4 class="modal-title font-weight-bold">Create Bank</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form enctype="multipart/form-data" method="post" action="{{ route('bank.store') }}">
              			@csrf
						<div class="modal-body pd-20">
							<div class="form-group">
								<input type="text" class="form-control" name="bank_id" id="bank_id" hidden>
								<label class="form-label" for="exampleInputEmail1">Name</label>
								<input type="text" class="form-control" name="name" id="name"  placeholder="Enter Name" required>
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
					document.getElementById("bank_id").value='';
					document.getElementById("name").value='';
				}

				function editModal(data){
					
    				$("#largeModal").modal();
					document.getElementById("bank_id").value=data.id;
					document.getElementById("name").value=data.name;
				}
			</script>
@endsection
