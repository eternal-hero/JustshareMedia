@extends('template.layout')

@section('title', 'Failed transactions | Just Share Roofing Media')

@section('description', 'Failed transactions')

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
                        <h3>Failed transactions</h3>
                        <span>Failed transactions</span>
                    </div>

                    <div class="clear"></div>

                    <div class="row clearfix">

                        <div class="col">

                            <table id="datatable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Reference</th>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Message</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Reference</th>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Message</th>
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
                                            {{ $transaction->reference }}
                                        </td>
                                        <td>
                                            {{ $transaction->created_at }}
                                        </td>
                                        <td>
                                            {{ $transaction->user->email }}
                                        </td>
                                        <td>
                                            {{ \GuzzleHttp\json_decode($transaction->authorize_request_obj)->order->description }}
                                        </td>
                                        <td>
                                            {{ $fmt->formatCurrency($transaction->amount, 'USD') }}
                                        </td>
                                        <td>
                                            @php
                                                if($transaction->authorize_response_errors){
                                                    $msg = \GuzzleHttp\json_decode($transaction->authorize_response_errors)[0]->errorText;
                                                } else {
                                                    $msg = \GuzzleHttp\json_decode($transaction->authorize_response_obj)->messages->message[0]->text;
                                                    if($msg == 'Successful.') {
                                                        $msg = 'Unknown -> missing auth code';
                                                    }
                                                }

                                            @endphp
                                            {{ $msg }}
{{--                                            @php--}}
{{--                                                $couponCode = false;--}}
{{--                                                if($transaction->order->coupon_id) {--}}
{{--                                                    $coupon = \App\Models\Coupon::find($transaction->order->coupon_id);--}}
{{--                                                    if($coupon) {--}}
{{--                                                        $couponCode = $coupon->code;--}}
{{--                                                    }--}}
{{--                                                }--}}
{{--                                            @endphp--}}
{{--                                            {{ $fmt->formatCurrency(\App\Models\Order::calculatePrice($transaction->plan_id, $transaction->term, $transaction->user->state_code, $couponCode)['price'], 'USD') }}--}}
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
