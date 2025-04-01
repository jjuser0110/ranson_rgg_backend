@extends('layouts.app')


@section('content')
					<div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Rent</h2>
                           </div>
                        </div>
                     </div>
                     <div class="row column1">
							<div class="col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Table List</div>
										
										<a class="btn btn-primary" onclick="openModal()" style="float:right;color:white">Create</a>
									</div>
									<div class="card-body">
										<div class="table_section padding_infor_info">
											<div class="table-responsive-sm" style="overflow-x: hidden;">
												<table id="example2" class="table table-bordered " style="width:100%">
												<thead>
													<tr>
														<th width="15%">Date</th>
														<th width="15%">Name</th>
														<th width="15%">Amount ({{env('CURRENCY')}})</th>
														<th width="15%">Month ~ Year</th>
														<th width="30%">Remarks</th>
														<th width="10%">Actions</th>
													</tr>
												</thead>
												<tbody>
														@foreach($rent as $u)
													<tr>
														<td>{{$u->pay_date??''}}</td>
														<td>{{$u->user_id??''}}</td>
														<td>{{$u->amount??''}}</td>
														<td><?php echo isset($u->month)?date("F", mktime(0, 0, 0, $u->month, 10)):'' ?> {{$u->year ??''}}</td>
														<td>{{$u->remarks??''}}</td>
														<td>
														<button class="btn btn-sm btn-info" onclick="editModal({{$u}})">
														<i class="fa fa-pencil" aria-hidden="true"></i>
														</button>
														<button class="btn btn-sm btn-info" onclick="if(confirm('Are you sure you want to delete?')){ window.location.href='{{ route('rent.destroy',$u) }}' }">
														<i class="fa fa-trash" aria-hidden="true"></i>
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
						</div>
			<div id="largeModal" class="modal fade">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content ">
						<div class="modal-header pd-x-20">
							<h4 class="modal-title font-weight-bold">Create Rent</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form enctype="multipart/form-data" method="post" action="{{ route('rent.store') }}">
              			@csrf
						<div class="modal-body pd-20">
								<input type="text" class="form-control" name="rent_id" id="rent_id" hidden>
							<div class="form-group">
								<label class="form-label" for="exampleInputEmail1">Name</label>
								<input type="text" class="form-control" name="user_id" id="user_id"  placeholder="Enter Name" >
							</div>
							<div class="form-group">
								<label class="form-label" for="exampleInputEmail1">Pay Date</label>
								<input type="date" class="form-control" name="pay_date" id="pay_date"  required>
							</div>
							<div class="form-group">
								<label class="form-label" for="exampleInputEmail1">Amount</label>
								<input type="number" step="0.01" class="form-control" name="amount" id="amount" required>
							</div>
							<div class="form-group">
								<label class="form-label" for="exampleInputEmail1">Remarks</label>
								<input type="text" class="form-control" name="remarks" id="remarks"  placeholder="Enter Remarks" >
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
					document.getElementById("rent_id").value='';
					document.getElementById("user_id").value='';
					document.getElementById("remarks").value='';
					document.getElementById("pay_date").value='';
					document.getElementById("amount").value='';
				}

				function editModal(data){
					
    				$("#largeModal").modal();
					document.getElementById("rent_id").value=data.id;
					document.getElementById("user_id").value=data.user_id;
					document.getElementById("remarks").value=data.remarks;
					document.getElementById("pay_date").value=data.pay_date;
					document.getElementById("amount").value=data.amount;
				}
			</script>
@endsection
