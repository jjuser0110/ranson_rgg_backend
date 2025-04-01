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
							<!-- <a class="btn btn-primary" onclick="openModal()" style="float:right;color:white">Create</a> -->
											@endif
						</div>
						<div class="card-body">	
						<div class="table_section padding_infor_info">
							<div class="table-responsive-sm">
								<table id="monthly_rent" class="table table-bordered " style="width:100%">
									<thead>
										<tr>
											<th>Card Name</th>
											<th>Card No</th>
											<th>Card Bank</th>
											<th>Date From</th>
											<th>Date To</th>
											<th>No of Days</th>
											<th>Cost</th>
											<th>Price</th>
											<th>Pay Date</th>
											<th>Agent</th>
											@if(Auth::user()->role == "Masteradmin")
											<th>Actions</th>
											<th><button class="btn btn-sm btn-success" onclick="if(confirm('Are you sure you want to mark as paid?')){ markAllPay() }">
													MAP
													</button>
											</th>
											@endif
										</tr>
									</thead>
									<tbody>
										@foreach($rent_item as $u)
										<tr>
											<td>{{$u->card->card_name ??''}}</td>
											<td>{{$u->card->card_no ??''}}</td>
											<td>{{$u->card->bank->name ??''}}</td>
											<td>{{$u->date_from ??''}}</td>
											<td>{{$u->date_to ??''}}</td>
											<td>{{$u->no_of_days ??''}}</td>
											<td>{{$u->cost??''}}</td>
											<td>{{$u->price??''}}</td>
											<td>{{$u->pay_date??''}}</td>
											<td>{{$u->card->agentdetail->username??''}}</td>
											@if(Auth::user()->role == "Masteradmin")
											<td>
													@if(is_null($u->pay_date))
													<button class="btn btn-sm btn-info" onclick="if(confirm('Are you sure you want to delete?')){ window.location.href='{{ route('rent.destroyitem',$u) }}' }">
														<i class="fa fa-trash" aria-hidden="true"></i>
													</button>
													<button class="btn btn-sm btn-success" onclick="if(confirm('Are you sure you want to mark as paid?')){ window.location.href='{{ route('rent.mark_paid',$u) }}' }">
													MP
													</button>
													@endif
											</td>
											<th>
													@if(is_null($u->pay_date))
													<input type="checkbox" class="checkbox-item" value="{{$u->id}}">
													@endif
											</th>
											@endif
										</tr>
										@endforeach
									</tbody>
									<tfoot>
										<tr>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th>Total:</th>
											<th></th>
											<th></th>
											<th></th>
											@if(Auth::user()->role == "Masteradmin")
											<th></th>
											<th></th>
											@endif
										</tr>
									</tfoot>
								</table>

								</div>
							</div>
						</div>
					</div>
				</div>
		</div>

@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
	$(document).ready(function() {
		var table = $('#monthly_rent').DataTable({
			"columnDefs": [
				{
					"targets": [10, 11], // Columns 10 and 11
					"orderable": false  // Disable sorting
				}
			],
			"footerCallback": function (row, data, start, end, display) {
				var api = this.api();
				var total = api.column(7, {page: 'current'}).data().reduce(function (acc, val) {
					return acc + parseFloat(val);
				}, 0);
				$(api.column(7).footer()).html(total.toFixed(2));
			}
		});
	});
	
	var $j = jQuery.noConflict();
	function markAllPay(){
		var checkboxes = document.querySelectorAll("input[type='checkbox']");
		var selectedValues = [];

		checkboxes.forEach(function (checkbox) {
			if (checkbox.checked) {
				selectedValues.push(checkbox.value);
			}
		});

		var postData = {};
        postData.rent_ids = selectedValues;
        postData._token = "{{ csrf_token() }}";
        $j.ajax({
            url: "{{ route('rent.mark_all_pay')}}",
            method: "POST",
            data: postData,
            success: function(response){
              location.reload();
            },
            complete: function() {
                //btn.disabled = false;
            }
        });
	}
</script>