@extends('layouts.app')

@section('content')
<div class="row column_title">
    <div class="col-md-12">
        <div class="page_title">
            <h2>Transaction Details</h2>
        </div>
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('transaction.index') }}">Transaction</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $transaction->inv_no }}</li>
            </ol>
        </div>
    </div>
 </div>
<div class="row">
    <div class="col-lg-5 col-xl-4">
        <div class="card card-profile cover-image "  data-image-src="{{ asset('assets/images/photos/gradient3.jpg') }}">
            <div class="card-body text-center">
                <img class="card-profile-img" src="{{ asset('storage/' . $transaction->bank_receipt)}} " alt="img">
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
                                        <td><strong>Transaction No :</strong></td>
                                        <td>{{ $transaction->inv_no }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Date Time :</strong></td>
                                        <td>{{ $transaction->datetime }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>User ID :</strong></td>
                                        <td>{{ $transaction->user->userid ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>User Name :</strong></td>
                                        <td>{{ $transaction->user->name ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Player ID :</strong></td>
                                        <td>{{ $transaction->player_id ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Payment :</strong></td>
                                        <td>{{ $transaction->payment ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status :</strong></td>
                                        <td>{{ $transaction->status ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Product:</strong></td>
                                        <td>{{ $transaction->product_variant->name ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Price :</strong></td>
                                        <td>RM {{ number_format($transaction->cost, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Quantity :</strong></td>
                                        <td>{{ $transaction->qty }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Amount :</strong></td>
                                        <td>RM {{ number_format($transaction->amount, 2) }}</td>
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
