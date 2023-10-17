    <div class="content-wrap">
        <div class="container clearfix">

            <div class="row clearfix">

                <div class="col-md-12">

                    <div class="heading-block border-0">
                        <h3>Order #{{ $order->id }} - {{ ucwords($order->status) }}</h3>
                        <span>Ordered on {{ $order->created_at }}</span>
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
            </div>

        </div>
    </div>
