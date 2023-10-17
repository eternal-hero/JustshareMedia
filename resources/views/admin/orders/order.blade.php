@extends('template.layout')

@section('title', 'Order #' . $order->id . ' | Just Share Roofing Media')

@section('description', 'Managing an order')

@section('js_additional')
    <script src="/assets/js/components/bs-datatable.js"></script>
    <script>
		$(document).ready(function() {
			$('#datatable1').dataTable( {
                "order": [[ 0, "asc" ]]
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
                    <h3><a href='{{ route('admin.orders') }}'>Orders</a> > #{{ $order->id }} - {{ $order->status }}</h3>
                    <span>Ordered on {{ $order->created_at }} by <a href='/admin/accounts/{{ $order->user->id }}'>{{ $order->user->first_name}} {{ $order->user->last_name }}</a></span>
                </div>

                <div class="clear"></div>
                <div class="row clearfix">
                    <div class="col">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                <i class="icon-exclamation-triangle"></i> {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                <i class="icon-check-circle"></i> {{ session('success') }}
                            </div>
                        @endif
                        <p>This order is <b>{{ $order->status }}</b>.</p>
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
