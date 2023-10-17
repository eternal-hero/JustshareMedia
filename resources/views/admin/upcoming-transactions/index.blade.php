@extends('template.layout')

@section('title', 'Upcoming transactions | Just Share Roofing Media')

@section('description', 'Upcoming transactions')

@section('js_additional')
    <script src="/assets/js/components/bs-datatable.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable1').dataTable({
                "bSort" : false
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
                        <h3>Upcoming transactions</h3>
                        <span>Upcoming transactions</span>
                    </div>

                    <div class="clear"></div>

                    <div class="row clearfix">

                        <div class="col">

                            <table id="datatable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Settlement date</th>
                                    <th>User</th>
                                    <th>Company</th>
                                    <th>Amount</th>
                                    <th>Actions</th>
                                    <th>Current plan</th>
                                    <th>Will switch to:</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Settlement date</th>
                                    <th>User</th>
                                    <th>Company</th>
                                    <th>Amount</th>
                                    <th>Actions</th>
                                    <th>Current plan</th>
                                    <th>Will switch to:</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @php
                                    $fmt = new NumberFormatter( 'us_US', NumberFormatter::CURRENCY );
                                @endphp
                                @foreach ($data['items'] as $transaction)
                                    <tr>
                                        <td>
                                            {{ $transaction->id }}
                                        </td>
                                        <td>
                                            {{ $transaction->end_at->format('Y-m-d') }}
                                        </td>
                                        <td>
                                            {{ $transaction->user->email }}
                                        </td>
                                        <td>
                                            {{ $transaction->user->company }}
                                        </td>
                                        <td>
                                            @php
                                                if($transaction->custom_price) {
                                                    $tax = \App\Models\Order::calculateTax($transaction->custom_price, $transaction->user->state);
                                                    echo 'Plan:' . $fmt->formatCurrency($transaction->custom_price, 'USD');
                                                    echo '<br> Tax:' . $fmt->formatCurrency($tax, 'USD');
                                                    echo '<br> <b>Total</b>:' . $fmt->formatCurrency($transaction->custom_price + $tax, 'USD');
                                                } else {
                                                    $couponCode = false;
                                                    if($transaction->order->coupon_id) {
                                                        $coupon = \App\Models\Coupon::find($transaction->order->coupon_id);
                                                        if($coupon) {
                                                            $couponCode = $coupon->code;
                                                        }
                                                    }
                                                    $now = \Carbon\Carbon::now();
                                                    $term = $transaction->term;
                                                    $diffDays = $transaction->term === 'yearly' ? 365-30 : 30;
                                                    if($now->diffInDays($transaction->end_at) < $diffDays && $transaction->switch_to) {
                                                        $term = $transaction->switch_to;
                                                    }
                                                    $price = \App\Models\Order::calculatePrice($transaction->plan_id, $term, $transaction->user->state, $couponCode);
                                                    echo 'Plan:' . $fmt->formatCurrency($price['original'], 'USD');
                                                    echo '<br> Discount:' . $fmt->formatCurrency($price['coupon_value'], 'USD');
                                                    echo '<br> Tax:' . $fmt->formatCurrency($price['tax'], 'USD');
                                                    echo '<br> <b>Total</b>:' . $fmt->formatCurrency($price['price'], 'USD');
                                                }
                                            @endphp
                                            <br>
                                            <a href="{{ route('upcoming-transactions.change-price', ['subscription' => $transaction->id]) }}">Change Price</a>
                                        </td>
                                        <td>
                                            @if($transaction->term == 'contract')
                                                <a href="{{ route('update.subscription.type', ['subscription' => $transaction->id, 'type' => 'monthly']) }}">Switch to monthly</a><br>
                                                <a href="{{ route('update.subscription.type', ['subscription' => $transaction->id, 'type' => 'yearly']) }}">Switch to yearly</a>
                                            @endif
                                            @if($transaction->term == 'monthly')
                                                <a href="{{ route('update.subscription.type', ['subscription' => $transaction->id, 'type' => 'contract']) }}">Switch to contract</a><br>
                                                <a href="{{ route('update.subscription.type', ['subscription' => $transaction->id, 'type' => 'yearly']) }}">Switch to yearly</a>
                                            @endif
                                            @if($transaction->term == 'yearly')
                                                <a href="{{ route('update.subscription.type', ['subscription' => $transaction->id, 'type' => 'monthly']) }}">Switch to monthly</a><br>
                                                <a href="{{ route('update.subscription.type', ['subscription' => $transaction->id, 'type' => 'contract']) }}">Switch to contract</a>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $transaction->term }}
                                        </td>
                                        <td>
                                            {{ $transaction->switch_to }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="w-100 line d-block d-md-none"></div>
                <div class="col-md-3">
                    <x-dashboard-menu/>
                </div>
            </div>

        </div>
    </div>

@endsection
