@extends('layouts.app')

@section('content')

<div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Expense</h2>
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
												<table id="example8" class="table table-bordered " style="width:100%">
												<thead>
													<tr>
														<th>Date</th>
														<th>Description</th>
														<th>Amount ({{env('CURRENCY')}})</th>
														<th>Month ~ Year</th>
														<th>Agent</th>
														@if(Auth::user()->role == "Masteradmin") 
														<th>Actions</th>
														@endif
													</tr>
												</thead>
												<tbody>
														@foreach($expense as $u)
													<tr>
														<td>{{$u->claim_date??''}}</td>
														<td>{{$u->description??''}}</td>
														<td>{{$u->amount??''}}</td>
														<td><?php echo isset($u->month)?date("F", mktime(0, 0, 0, $u->month, 10)):'' ?> {{$u->year ??''}}</td>
														<td>{{$u->agentdetail->username??''}}</td>
														@if(Auth::user()->role == "Masteradmin") 
														<td>
														<button class="btn btn-sm btn-info" onclick="editModal({{$u}})">
														<i class="fa fa-pencil" aria-hidden="true"></i>
														</button>
														<button class="btn btn-sm btn-info" onclick="if(confirm('Are you sure you want to delete?')){ window.location.href='{{ route('expense.destroy',$u) }}' }">
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
							<h4 class="modal-title font-weight-bold">Create Expense</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form enctype="multipart/form-data" method="post" action="{{ route('expense.store') }}">
              			@csrf
						<div class="modal-body pd-20">
							<div class="form-group">
								<label class="form-label" for="exampleInputEmail1">Agent</label>
								<select class="form-control" id="user_id" name="user_id" required @if(Auth::user()->role != "Masteradmin") echo disabled @endif>
									@foreach($agent as $a)
									<option value="{{$a->id}}">{{$a->username}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" name="expense_id" id="expense_id" hidden>
								<label class="form-label" for="exampleInputEmail1">Description</label>
								<input type="text" class="form-control" name="description" id="description"  placeholder="Enter Description" required>
							</div>
							<div class="form-group">
								<label class="form-label" for="exampleInputEmail1">Claim Date</label>
								<input type="date" class="form-control" name="claim_date" id="claim_date"  required>
							</div>
							<div class="form-group">
								<label class="form-label" for="exampleInputEmail1">Amount</label>
								<input type="number" step="0.01" class="form-control" name="amount" id="amount" required>
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
					document.getElementById("expense_id").value='';
					document.getElementById("user_id").value='';
					document.getElementById("description").value='';
					document.getElementById("claim_date").value='';
					document.getElementById("amount").value='';
				}

				function editModal(data){
					
    				$("#largeModal").modal();
					document.getElementById("expense_id").value=data.id;
					document.getElementById("user_id").value=data.user_id;
					document.getElementById("description").value=data.description;
					document.getElementById("claim_date").value=data.claim_date;
					document.getElementById("amount").value=data.amount;
				}
			</script>
@endsection
