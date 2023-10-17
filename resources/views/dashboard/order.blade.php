@extends('template.layout')

@section('title', 'Order #' . $order->id . ' | ' . config('app.name'))

@section('description', 'Viewing an order')

@section('js_additional')
    <script src="/assets/js/components/bs-datatable.js"></script>
    <script>
		$(document).ready(function() {
			$('#datatable1').dataTable( {
                "order": [[ 0, "desc" ]]
            });
        });
	</script>
@endsection

@section('content')

<div class="content-wrap">
    <div class="container clearfix">

        <div class="row clearfix">

            <div class="col-md-9">

                <div class="heading-block border-0">
                    <h3><a href='/dashboard/orders/'>My Orders</a> > Order #{{ $order->id }} - {{ ucwords($order->status) }}</h3>
                    <span>Ordered on {{ $order->created_at }}</span>
                </div>

                <div class="clear"></div>

                <div class="row clearfix">

                    <div class="col">
                        <span style='float:right'><a href='{{route('download.invoice', $order)}}' class='btn btn-primary'><i class='icon-line-printer'></i> Print Invoice</a></span>

                        <p>Your order is <b>{{ $order->status }}</b>.</p>

                    </div>

                </div>

                @if ($order->hasTransactions())
                    <br/>

                    <div class='row'>
                        <div class='col'>
                            <h4>Transactions</h4>
                            <table class='table'>
                                <tr>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Coupon Amt</th>
                                    <th>Tax</th>
                                    <th>Total</th>
                                    <th>ID</th>
                                    <th>Auth Code</th>
                                    <th>Date</th>
                                </tr>
                                @foreach ($order->getTransactions() as $transaction)
                                    <tr>
                                        <td>{{ $transaction->type }}</td>
                                        <td>${{ $transaction->amount }}</td>
                                        <td>${{ $transaction->coupon_amount }}</td>
                                        <td>{{ $transaction->tax }}</td>
                                        <td>{{ $transaction->total }}</td>
                                        <td>{{ $transaction->authorize_transaction_id }}</td>
                                        <td>{{ $transaction->authorize_auth_code }}</td>
                                        <td>{{ $transaction->created_at }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td><b>Total</b></td>
                                    <td><b>${{ $order->getTotal() }}</b></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @endif

            </div>

            <div class="w-100 line d-block d-md-none"></div>

            <div class="col-md-3">

                <x-dashboard-menu/>

            </div>

        </div>

    </div>
</div>

@endsection
