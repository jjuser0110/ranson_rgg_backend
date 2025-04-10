@extends('layouts.app')

@section('content')
<div class="row column_title">
    <div class="col-md-12">
        <div class="page_title">
            <h2>Withdraws</h2>
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
                    <div class="table-responsive-sm" >
                        <table id="withdraw-table" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Reference No</th>
                                    <th>User ID</th>
                                    <th>User Name</th>
                                    <th>Bank</th>
                                    <th>Bank Account</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    @if(Auth::user()->username == "admin")
                                        <th>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($withdraws as $withdraw)
                                    <tr>
                                        <td>{{ $withdraw->date ?? '' }}</td>
                                        <td>{{ $withdraw->ref_no ?? '' }}</td>
                                        <td>{{ $withdraw->user->userid ?? '' }}</td>
                                        <td>{{ $withdraw->user->name ?? '' }}</td>
                                        <td>{{ $withdraw->bank ?? '' }}</td>
                                        <td>{{ $withdraw->bank_acc ?? '' }}</td>
                                        <td>{{ $withdraw->amount ?? '' }}</td>
                                        <td>{{ $withdraw->status ?? '' }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-info" onclick="window.location.href='{{ route('withdraw.view', $withdraw) }}'">
                                                <i class="fa fa-eye" aria-hidden="true" title="View"></i>
                                            </button>
                                            @if(Auth::user()->username == "admin")
                                                <button class="btn btn-sm btn-info" onclick="editModal({{ $withdraw }})">
                                                    <i class="fa fa-pencil" aria-hidden="true" title="Edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" onclick="if(confirm('Are you sure you want to delete?')){ window.location.href='{{ route('withdraw.destroy', $withdraw) }}' }">
                                                    <i class="fa fa-trash" aria-hidden="true" title="Delete"></i>
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
</div>
<div id="modalModal" class="modal fade">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content ">
            <div class="modal-header pd-x-20">
                <h4 class="modal-title font-weight-bold">Create Withdraw</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" action="{{ route('withdraw.store') }}">
            @csrf
            <div class="modal-body pd-20">
                <div class="form-group">
                    <input type="hidden" name="withdraw_id" id="withdraw_id">
                    <label class="form-label" for="exampleInputEmail1">Date </label>
                    <input type="date" class="form-control" name="date" id="date" value="{{ date('Y-m-d') }}" required>
                    <label class="form-label" for="exampleInputEmail1">Reference No</label>
                    <input type="text" class="form-control" name="reference_no" id="reference_no"  placeholder="Enter Reference No" required>
                    <label class="form-label" for="exampleInputEmail1">User</label>
                    <select class="form-control" name="user_id" id="user_id">
                        <option value = "">-- Select --</option>
                        @foreach($users as $user)
                        <option value="{{$user->id??''}}">{{$user->name??''}}</option>
                        @endforeach
                    </select >
                    <label class="form-label" for="exampleInputEmail1">Bank</label>
                    <input type="text" class="form-control" name="bank" id="bank"  placeholder="Enter Bank" required>
                    <label class="form-label" for="exampleInputEmail1">Bank Account</label>
                    <input type="text" class="form-control" name="bank_acc" id="bank_acc" placeholder="Enter Bank Account" required>
                    <label class="form-label" for="exampleInputEmail1">Amount</label>
                    <input type="number" step="0.01" class="form-control" name="amount" id="amount"  placeholder="Enter Amount">
                    <label class="form-label" for="exampleInputEmail1">Status</label>
                    <select class="form-control" name="status" id="status">
                        <option value="Pending">Pending</option>
                        <option value="Success">Success</option>
                        <option value="Reject">Reject</option>
                    </select >
                    <label class="form-label" for="exampleInputEmail1">Upload Receipt</label>
                    <input type="file" class="form-control" name="file_attachment" id="file" accept="image/*">
                    <img class="card-profile-img" id="receipt_path" src="" alt="img" style="display:none; max-width: 400px;">
                </div>
            </div><!-- modal-body -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div><!-- modal-dialog -->
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#withdraw-table').DataTable({
            order: [[0, 'desc']]
        });
    });
</script>
<script>
    function openModal(){

        $("#modalModal").modal();
        document.getElementById("withdraw_id").value='';
        document.getElementById("date").value=date('Y-m-d');
        document.getElementById("reference_no").value='';
        document.getElementById("user_id").value='';
        document.getElementById("bank").value='';
        document.getElementById("bank_acc").value='';
        document.getElementById("amount").value='';
        document.getElementById("status").value='';
        document.getElementById("receipt_path").style.display = "none";
        document.getElementById("receipt_path").value='';
    }

    function editModal(data){
        $("#modalModal").modal();
        document.getElementById("withdraw_id").value=data.id;
        document.getElementById("date").value=data.date;
        document.getElementById("reference_no").value=data.reference_no;
        document.getElementById("user_id").value=data.user_id;
        document.getElementById("bank").value=data.bank;
        document.getElementById("bank_acc").value=data.bank_acc;
        document.getElementById("amount").value=data.amount;
        document.getElementById("status").value=data.status;
        if (data.receipt !== '') {
            console.log("{{ asset('storage') }}/" + data.receipt);
            document.getElementById("receipt_path").src= "{{ asset('storage') }}/" + data.receipt;
            document.getElementById("receipt_path").style.display = "block";
        }
    }
</script>
@endsection
