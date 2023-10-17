@extends('template.layout')

@section('title', 'Dashboard | ' . config('app.name'))

@section('description', 'Your account and settings')

@section('content')

    <div class="content-wrap">
        <div class="container clearfix">
            <div class="row clearfix">
                <div class="col-md-9">
                    <div class="heading-block border-0">
                        <h3>My Subscriptions</h3>
                        <span>{{ $user->email }}</span>
                    </div>
                    <div class="row">
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
                        </div>
                    </div>
                    <div class="clear"></div>
                    @if($subscription)
                        <div class="row clearfix">
                            <div class="col-lg-3">Plan:</div>
                            <div class="col-lg-9">{{ $subscription->plan->name }}</div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-3">Price:</div>
                            <div class="col-lg-9">

                                @php
                                    $fmt = new NumberFormatter( 'us_US', NumberFormatter::CURRENCY );
                                      if($subscription->custom_price) {
                                          $tax = \App\Models\Order::calculateTax($subscription->custom_price, $subscription->user->state);
                                          echo $fmt->formatCurrency($subscription->custom_price + $tax, 'USD');
                                      } else {
                                          $couponCode = false;
                                          if($subscription->order->coupon_id) {
                                              $coupon = \App\Models\Coupon::find($subscription->order->coupon_id);
                                              if($coupon) {
                                                  $couponCode = $coupon->code;
                                              }
                                          }
                                          $now = \Carbon\Carbon::now();
                                          $term = $subscription->term;
                                          $diffDays = $subscription->term === 'yearly' ? 365-30 : 30;
                                          $price = \App\Models\Order::calculatePrice($subscription->plan_id, $term, $subscription->user->state, $couponCode);
                                          echo $fmt->formatCurrency($price['price'], 'USD');
                                      }
                                @endphp

                            </div>
                        </div>
                        @if(!$subscription->should_cancel_at)
                            <div class="row clearfix">
                                <div class="col-lg-3">Renewal Date:</div>
                                <div class="col-lg-9">{{ $renewalDate->format('Y-m-d') }}</div>
                            </div>
                        @else
                            <div class="row clearfix">
                                <div class="col-lg-3">Subscription valid due:</div>
                                <div class="col-lg-9">{{ $subscription->should_cancel_at->format('Y-m-d') }}</div>
                            </div>
                        @endif
                        {{--<div class="row clearfix">
                            <div class="col-lg-3">Remaining Downloads:</div>
                            <div class="col-lg-9">???</div>
                        </div>--}}
                        <div class="row clearfix">
                            <div class="col-lg-3">Account status:</div>
                            <div class="col-lg-9">
                                @if($subscription->status == 'canceled')
                                    <span>Your subscription is canceled, reactivate it <a
                                            href="{{ route('subscriptions.reactivate') }}">here</a></span>
                                @else
                                    {{ $subscription->status }}
                                @endif
                            </div>
                        </div>
                        @if($subscription->status === \App\Models\Subscription::STATUS_UNPAID)
                            <div class="row clearfix">
                                <div class="col-lg-3">Pay for subscription</div>
                                <div class="col-lg-9"><a href="{{ route('manual-pay') }}">Pay with existing method
                                        ({{ str_repeat('*', strlen($subscription->user->cardnumber) - 4) . substr($subscription->user->cardnumber, -4) }}
                                        )</a> or <a href="{{ route('dashboard.billing') }}">Change payment method</a>
                                </div>
                            </div>
                        @endif
                        {{--                        <div class="row clearfix">--}}
                        {{--                            <div class="col-lg-3">Authorize.net ID:</div>--}}
                        {{--                            <div class="col-lg-9">{{ $subscription->authorize_subscription_id }}</div>--}}
                        {{--                        </div>--}}
                        <div class="row clearfix">
                            <div class="col-lg-3">Invoices:</div>
                            <div class="col-lg-9"><a
                                    href="{{ route('dashboard.order.update', $subscription->order_id) }}">View invoice
                                    history</a></div>
                        </div>
                        <div class="row clearfix">
                            <div class="col">
                                &nbsp;
                            </div>
                        </div>
                        @if(!$subscription->should_cancel_at)
                            @if($subscription->status == 'active')
                                <div class="row clearfix">
                                    <div class="col-lg-12 float-left">
                                        <form id="cancelSubscriptionForm" method="post"
                                              action="{{route('cancel.subscription', $subscription->id)}}">
                                            @csrf
                                            <button class="button button-3d cancel-popup-trigger">
                                                <i class="icon-remove-sign"></i> Cancel Subscription
                                            </button>

                                        </form>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @else
                        <div class="row clearfix">
                            <div class="col-lg-12"><h3>You have no subscriptions yet.</h3></div>
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

    <div class="confirmationPopupWrapper">
        <div class="confirmationPopup">
            <div class="confirmationPopup-close">
                <img src="{{ asset('assets/images/close.png') }}" alt="close">
            </div>
            <div class="confirmationPopup-title">Are you sure you want to cancel your subscription?</div>
            <div class="confirmationPopup-text">Once your subscription is canceled, you will no longer have the rights
                to use any videos licensed through our service. Confirm that you have read our
                <a target="_blank" href="{{ route('terms-conditions') }}">Terms & Conditions</a>.
            </div>
            <div class="confirmationPopup-checkbox">
                <input class="tocConfirmed" type="checkbox"> I’ve read and agree to Terms & Conditions
            </div>
            <div class="confirmationPopup-closebtn">
                Continue Subscription
            </div>
            <div class="confirmationPopup-cancelbtn">
                No thanks, I want to cancel subscription
            </div>
        </div>
    </div>

    @if(\Illuminate\Support\Facades\Session::has('cancelResult'))
        <div class="subsCanceledPopupWrapper">
            <div class="subsCanceledPopup">
{{--                <div class="subsCanceledPopup-close">--}}
{{--                    <img src="{{ asset('assets/images/close.png') }}" alt="close">--}}
{{--                </div>--}}
                <div class="subsCanceledPopup-title">Your subscription was canceled</div>
                <div class="subsCanceledPopup-text">Your paid period runs out
                    at {{ $subscription->should_cancel_at->format('Y-m-d') }}. After this date you won't have rights to
                    use videos licensed through our service.
                    To reactivate your subscription at any time go to Account Settings.
                </div>
                <div class="subsCanceledPopup-text">
                    Cancel reason
                </div>
                <div class="subsCanceledPopup-text">
                    @foreach($cancelReasons as $i => $cancelReason)
                        <div class="input-group" style="display: flex; align-items: center;">
                            <input name="reason" value="{{ $cancelReason->id }}"
                                   id="rsn-{{ $cancelReason->id }}"
                                   type="radio"
                                   class="reasonInput {!! $cancelReason->show_text_field ? 'showTextField' : '' !!}"
                            >
                            <label style="margin: 0 0 0 10px"
                                   for="rsn-{{ $cancelReason->id }}">{{ $cancelReason->name }}</label>
                        </div>
                    @endforeach
                    <textarea class="reasonTextField" style="display: none; width: 100%" placeholder="Type your reason"></textarea>
                </div>
                <div class="cancelReasonErrorMsg" style="display:none; color: red">Please select a reason for canceling.</div>
                <div class="subsCanceledPopup-closebtn">
                    OK
                </div>
            </div>
        </div>
    @endif

@endsection

@section('css_additional')
    <style>
        .subsCanceledPopupWrapper {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            z-index: 9999;
            background: rgba(0, 0, 0, 0.6);
        }

        .subsCanceledPopup {
            position: relative;
            width: 630px;
            margin: 0 auto;
            background: white;
            border: solid 1px #EEEEEE;
            border-radius: 6px;
            padding: 80px;
        }

        .subsCanceledPopup-text {
            font-family: Lato;
            font-weight: normal;
            font-size: 16px;
            line-height: 145%;
            text-align: center;
            margin-bottom: 18px;
        }

        .subsCanceledPopup-title {
            font-family: Poppins;
            font-weight: 600;
            font-size: 20px;
            text-align: center;
            margin-bottom: 16px;
        }

        .subsCanceledPopup-closebtn {
            border: 1px solid #D3D3D3;
            text-align: center;
            padding: 15px 0 15px 0;
            border-radius: 6px;
            cursor: pointer;
            font-family: Lato;
            font-weight: 500;
            font-size: 20px;
        }

        .subsCanceledPopup-close {
            position: absolute;
            right: 20px;
            top: 20px;
            cursor: pointer;
        }


        .confirmationPopupWrapper {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            display: none;
            flex-direction: column;
            justify-content: center;
            z-index: 9999;
            background: rgba(0, 0, 0, 0.6);
        }

        .confirmationPopup {
            position: relative;
            width: 630px;
            margin: 0 auto;
            background: white;
            border: solid 1px #EEEEEE;
            border-radius: 6px;
            padding: 80px;
        }

        .confirmationPopup-close {
            position: absolute;
            right: 20px;
            top: 20px;
            cursor: pointer;
        }

        .confirmationPopup-title {
            font-family: Poppins;
            font-weight: 600;
            font-size: 20px;
            text-align: center;
            margin-bottom: 16px;
        }

        .confirmationPopup-text {
            font-family: Lato;
            font-weight: normal;
            font-size: 16px;
            line-height: 145%;
            text-align: center;
            margin-bottom: 18px;
        }

        .confirmationPopup-checkbox input {
            margin-right: 11px;
        }

        .confirmationPopup-closebtn {
            background: #1477FB;
            border-radius: 4px;
            padding: 13px 0 13px 0;
            color: white;
            text-align: center;
            margin: 30px 0 15px 0;
            font-size: 20px;
            cursor: pointer;
        }

        .confirmationPopup-cancelbtn {
            border: 1px solid #D3D3D3;
            text-align: center;
            padding: 15px 0 15px 0;
            border-radius: 6px;
            cursor: not-allowed;
            font-family: Lato;
            font-weight: 500;
            font-size: 20px;
        }
    </style>
@endsection

@section('js_additional')
    <script>

        $('.reasonInput').click(function () {
            if ($(this).hasClass('showTextField')) {
                $('.reasonTextField').css({
                    display: 'block'
                })
            } else {
                $('.reasonTextField').css({
                    display: 'none'
                })
            }
        })

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": '{{ csrf_token() }}'
            }
        });
        let tocConfirmed = false;
        $(document).ready(function () {
            $('.subsCanceledPopup-closebtn').click(function () {
                if ($('input[name=reason]:checked').val()) {
                    if($('.reasonTextField').is(":visible")) {
                        if($('.reasonTextField').val() === '') {
                            $('.cancelReasonErrorMsg').css('display', 'flex')
                            return
                        }
                    }
                    const data = {
                        reason_id: $('input[name=reason]:checked').val(),
                        subscription_id: {{ $subscription->id }},
                        comment: $('.reasonTextField').val()
                    }
                    console.log(data)
                    $.ajax({
                        url: '{{route('subscriptions.reactivate.cancel-reason')}}',
                        type: 'POST',
                        data,
                        success: function (response) {
                            $('.subsCanceledPopupWrapper').css('display', 'none')
                        },
                        error: function (error) {
                            $('.subsCanceledPopupWrapper').css('display', 'none')
                        },
                        beforeSend: function () {
                            // $('#loader').show();
                        },
                        cache: false,
                        // contentType: false,
                        // processData: false
                    });
                } else {
                    $('.cancelReasonErrorMsg').css('display', 'flex')
                }
            })
            $('.subsCanceledPopup-close').click(function () {
                $('.subsCanceledPopupWrapper').css('display', 'none')
            })
            $('.tocConfirmed').change(function () {
                if ($(this).is(':checked')) {
                    tocConfirmed = true
                    $('.confirmationPopup-cancelbtn').css('cursor', 'pointer')
                } else {
                    $('.confirmationPopup-cancelbtn').css('cursor', 'not-allowed')
                    tocConfirmed = false
                }
            })
            $('.cancel-popup-trigger').click(function (e) {
                $('.confirmationPopupWrapper').css('display', 'flex')
                return false;
            })
            $('.confirmationPopupWrapper').click(function (e) {
                if (e.target !== this) {
                    return;
                }
                $(this).css('display', 'none')
            })
            $('.confirmationPopup-close').click(function () {
                $('.confirmationPopupWrapper').css('display', 'none')
            })
            $('.confirmationPopup-closebtn').click(function () {
                $('.confirmationPopupWrapper').css('display', 'none')
            })
            $(' .confirmationPopup-cancelbtn').click(function () {
                if (tocConfirmed) {
                    $('#cancelSubscriptionForm').submit();
                }
            })
        })
    </script>
@endsection
