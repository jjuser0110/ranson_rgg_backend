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
										<h4>{{$card->card_no }} ({{$card->card_name }})</h4>
										<!-- <a class="btn btn-primary" onclick="openModal()" style="float:right;color:white">Create</a> -->
									</div>
									<div class="card-body">
										<div class="table_section padding_infor_info">
											<div class="table-responsive-sm" style="overflow-x: hidden;">
												<table id="example2" class="table table-bordered " style="width:100%">
												<thead>
													<tr>
														<th width="15%">Month ~ Year</th>
														<th width="15%">Price ({{env('CURRENCY')}})</th>
														<th width="15%">Date From</th>
														<th width="15%">Date To</th>
														<th width="15%">No of Days</th>
														<th width="15%">Remarks</th>
														<th width="15%">Pay Date</th>
														
														@if(Auth::user()->role == "Masteradmin")
														<th width="15%">Actions</th>
														@endif
													</tr>
												</thead>
												<tbody>
														@foreach($card->rent_pay as $u)
													<tr>
														<td><?php echo isset($u->month)?date("F", mktime(0, 0, 0, $u->month, 10)):'' ?> {{$u->year ??''}}</td>
														<td>{{$u->price??''}}</td>
														<td>{{$u->date_from??''}}</td>
														<td>{{$u->date_to??''}}</td>
														<td>{{$u->no_of_days??''}}</td>
														<td>{{$u->remarks??''}}</td>
														<td>{{$u->pay_date??''}}</td>
														
														@if(Auth::user()->role == "Masteradmin")
														<td>
														<button class="btn btn-sm btn-info" onclick="editModal({{$u}})">
														<i class="fa fa-pencil" aria-hidden="true"></i>
														</button>
														@if(is_null($u->pay_date))
														<button class="btn btn-sm btn-info" onclick="if(confirm('Are you sure you want to delete?')){ window.location.href='{{ route('rent.destroyitem',$u) }}' }">
														<i class="fa fa-trash" aria-hidden="true"></i>
														</button>
														<button class="btn btn-sm btn-success" onclick="if(confirm('Are you sure you want to mark as paid?')){ window.location.href='{{ route('rent.mark_paid',$u) }}' }">
														MP
														</button>
														@endif
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
							<h4 class="modal-title font-weight-bold">Create Rent</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form enctype="multipart/form-data" method="post" action="{{ route('rent.storeRentItem') }}">
              			@csrf
						<div class="modal-body pd-20">
								<input type="text" class="form-control" name="rent_item_id" id="rent_item_id" hidden>
							<!-- <div class="form-group">
								<label class="form-label" for="exampleInputEmail1">Name</label>
								<input type="text" class="form-control" name="user_id" id="user_id"  placeholder="Enter Name" >
							</div>
							<div class="form-group">
								<label class="form-label" for="exampleInputEmail1">Pay Date</label>
								<input type="date" class="form-control" name="pay_date" id="pay_date"  required>
							</div> -->
							<div class="form-group">
								<label class="form-label" for="exampleInputEmail1">Price</label>
								<input type="number" step="0.01" class="form-control" name="price" id="price" required>
							</div>
							<div class="form-group">
								<label class="form-label" for="exampleInputEmail1">Remarks</label>
								<textarea class="form-control" name="remarks" id="remarks"  placeholder="Enter Remarks" rows="3"></textarea>
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
					
    				$("#largeModal").modal();
					document.getElementById("rent_item_id").value=data.id;
					document.getElementById("remarks").value=data.remarks;
					document.getElementById("price").value=data.price;
				}
			</script>
@endsection
