@extends('layouts.app')

@section('content')
<div class="row column_title">
    <div class="col-md-12">
        <div class="page_title">
            <h2>Withdraw Details</h2>
        </div>
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('withdraw.index') }}">Withdraw</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $withdraw->ref_no }}</li>
            </ol>
        </div>
    </div>
 </div>
<div class="row">
    <div class="col-lg-5 col-xl-4">
        <div class="card card-profile cover-image "  data-image-src="{{ asset('assets/images/photos/gradient3.jpg') }}">
            <div class="card-body text-center">
                @if ($withdraw->receipt)
                    <img class="card-profile-img" src="{{ asset('storage/' . $withdraw->receipt)}} " alt="img">
                @else
                    No receipt
                @endif

            </div>
        </div>
    </div>
    <div class="col-lg-7 col-xl-8">
        <div class="card">
            <div class="card-body">
                <div id="profile-log-switch">
                    <div class="fade show active " >
                        <div class="table-responsive border ">
                            <table class="table table-borderless w-100 m-0 ">
                                <tbody>
                                    <tr>
                                        <td><strong>Reference No :</strong></td>
                                        <td>{{ $withdraw->ref_no }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Date :</strong></td>
                                        <td>{{ $withdraw->date }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>User ID :</strong></td>
                                        <td>{{ $withdraw->user->userid ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>User Name :</strong></td>
                                        <td>{{ $withdraw->user->name ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Bank :</strong></td>
                                        <td>{{ $withdraw->bank ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Bank Acc :</strong></td>
                                        <td>{{ $withdraw->bank_acc ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Amount :</strong></td>
                                        <td>RM {{ number_format($withdraw->amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status :</strong></td>
                                        <td>{{ $withdraw->status ?? '' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

</script>
@endsection
