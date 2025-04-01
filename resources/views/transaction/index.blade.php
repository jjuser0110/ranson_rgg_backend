@extends('layouts.app')

@section('content')
<div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Transactions</h2>
                           </div>
                        </div>
                     </div>
                     <div class="row column1">
				<div class="col-md-12 col-lg-12">
					<div class="card">
						<div class="card-header">
							<div class="card-title">Table List</div>
							
							@if(Auth::user()->username == "admin")
							<a class="btn btn-primary" onclick="openModal()" style="float:right;color:white">Create</a>
							@endif
						</div>
						<div class="card-body">	
							<div class="table_section padding_infor_info">
								<div class="table-responsive-sm" style="overflow-x: hidden;">
									<table id="example2" class="table table-bordered " style="width:100%">
										<thead>
											<tr>
												<th>Transaction No</th>
												<th>Product</th>
												<th>Price</th>
												<th>QTY</th>
												<th>Amount</th>
												@if(Auth::user()->username == "admin")
												<th>Actions</th>
												@endif
											</tr>
										</thead>
										<tbody>
												@foreach($transaction as $u)
											<tr>
												<td>{{$u->inv_no??''}}</td>
												<td>{{$u->product_variant->name??''}}</td>
												<td>{{$u->cost??''}}</td>
												<td>{{$u->qty??''}}</td>
												<td>{{$u->amount??''}}</td>
												@if(Auth::user()->username == "admin")
												<td>
												<button class="btn btn-sm btn-info" onclick="if(confirm('Are you sure you want to delete?')){ window.location.href='{{ route('transaction.destroy',$u) }}' }">
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
			<div id="modalModal" class="modal fade">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content ">
						<div class="modal-header pd-x-20">
							<h4 class="modal-title font-weight-bold">Create Transactions</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form enctype="multipart/form-data" method="post" action="{{ route('transaction.store') }}">
              			@csrf
						<div class="modal-body pd-20">
							<div class="form-group">
								<label class="form-label" for="exampleInputEmail1">Transaction No</label>
								<input type="text" class="form-control" name="transaction_no" id="transaction_no"  placeholder="Enter Transaction No" required>
								<label class="form-label" for="exampleInputEmail1">Product</label>
								<select class="form-control" name="product_variant_id" id="product_variant_id">
									<option value = "">-- select --</option>
									@foreach($product_variant as $prod)
									<option value="{{$prod->id??''}}" data-price="{{$prod->price??0}}">{{$prod->name??''}}</option>
									@endforeach
								</select >
								<label class="form-label" for="exampleInputEmail1">Price</label>
								<input type="number" step="0.01" class="form-control" name="cost" id="cost" onchange="updateCount()" placeholder="Enter Price" required>
								<label class="form-label" for="exampleInputEmail1">Qty</label>
								<input type="number" class="form-control" name="qty" id="qty"  onchange="updateCount()" placeholder="Enter Qty" required>
								<label class="form-label" for="exampleInputEmail1">Amount</label>
								<input type="number" step="0.01" class="form-control" name="amount" id="amount"  placeholder="Enter Amount" readaonly>
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
					
    				$("#modalModal").modal();
					document.getElementById("transaction_id").value='';
					document.getElementById("cost").value='';
					document.getElementById("qty").value='';
					document.getElementById("amount").value='';
				}
			</script>
			<script>
				document.getElementById("product_variant_id").addEventListener("change", function () {
					let selectedOption = this.options[this.selectedIndex]; 
					let price = selectedOption.getAttribute("data-price") || 0; 
					console.log(price);
					document.getElementById("cost").value = price; 
					var qty = document.getElementById("qty").value || 1; 
					var amount = (price * qty).toFixed(2); // Ensures two decimal places
					document.getElementById("qty").value = qty; 
					document.getElementById("amount").value = amount; 

				});

				function updateCount(){
					var price = document.getElementById("cost").value; 
					var qty = document.getElementById("qty").value || 1; 
					var amount = (price * qty).toFixed(2); // Ensures two decimal places
					document.getElementById("qty").value = qty; 
					document.getElementById("amount").value = amount; 
				}
			</script>
@endsection
