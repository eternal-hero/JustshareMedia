@extends('template.layout')

@section('title', 'Dashboard | ' . config('app.name'))

@section('description', 'Your account and settings')

@section('content')

    <div class="content-wrap">
        <div class="container clearfix">
            <div class="row clearfix">
                <div class="col-md-9">
                    <div class="heading-block border-0">
                        <h3>Reactivate subscription</h3>
                        <span>{{ $user->email }}</span>
                    </div>
                    <form action="{{ route('subscriptions.reactivate.post') }}" method="post">
                        {{--                    user info--}}
                        <div class="row">
                            <div class="col">
                                <div class="row section-row">
                                    <div>Your info</div>
                                    <div><a href="{{ route('dashboard.profile') }}">Edit your info</a></div>
                                </div>
                                <div class="col">
                                    <div class="info-row">
                                        <div>First Name</div>
                                        <div>{{ $user->first_name }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div>Last Name</div>
                                        <div>{{ $user->last_name }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div>Email Address</div>
                                        <div>{{ $user->email }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div>Phone Number</div>
                                        <div>{{ $user->phone }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div>Business Name</div>
                                        <div>{{ $user->company }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div>Address</div>
                                        <div>{{ $user->address }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--                    subscription info--}}
                        <div class="row">
                            <div class="col">
                                <div class="row section-row">
                                    <div>Subscription info</div>
                                    <div><a href="{{ route('my-subscriptions.index') }}">More info</a></div>
                                </div>
                                <div class="col">
                                    <div class="info-row">
                                        <div>Type</div>
                                        <select class="typeSelect" name="type" id="">
                                            {{--                                        <option {{ $subscription->term == 'yearly' ? 'selected' : '' }} value="yearly">annual</option>--}}
                                            {{--                                        <option {{ $subscription->term == 'monthly' ||  $subscription->term == 'contract' ? 'selected' : '' }} value="contract">monthly</option>--}}
                                            @if($subscription->custom_price)
                                                <option value="custom">Custom Price</option>
                                            @else
                                                <option
                                                    {{ $subscription->term == 'yearly' ? 'selected' : '' }} value="yearly">
                                                    annual
                                                </option>
                                                <option
                                                    {{ $subscription->term == 'monthly' ||  $subscription->term == 'contract' ? 'selected' : '' }} value="contract">
                                                    monthly
                                                </option>
                                            @endif
                                        </select>
                                        {{--                                    --}}
                                        {{--                                    --}}
                                        {{--                                    <div>{{ $subscription->term == 'yearly' ? 'annual' : 'monthly' }}</div>--}}
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="info-row">
                                        <div>Price</div>
                                        <div class="info-row-price">${{ number_format(round($price, 2), 2) }}</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="info-row">
                                        <div>Discount</div>
                                        <div class="info-row-discount" style="font-weight: bold">
                                            ${{ number_format(round(0, 2), 2) }}</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="info-row">
                                        <div>Tax Rate</div>
                                        <div class="info-row-tax-rate">{{ number_format(round($taxRate, 2), 2) }}%</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="info-row">
                                        <div>Tax</div>
                                        <div class="info-row-tax">${{ number_format(round($taxAmount, 2), 2) }}</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="info-row">
                                        <div>Total</div>
                                        <div class="info-row-total" style="font-weight: bold">
                                            ${{ number_format(round($totalAmount, 2), 2) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--                    payment info info--}}
                        <div class="row">
                            <div class="col">
                                <div class="row section-row">
                                    <div>Payment method</div>
                                    <div><a href="{{ route('dashboard.billing') }}">Change payment method</a></div>
                                </div>
                                <div class="col">
                                    <div class="info-row">
                                        <div>Card number</div>
                                        <div>{{ $currentCreditCard }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(!$subscription->custom_price)
                            <div class="row">
                                <div class="col">
                                    <div class="row section-row">
                                        <div>Discount</div>
                                    </div>
                                    <div class="col">
                                        <div class="info-row">
                                            <div>Discount code</div>
                                            <div><input type="text" name="coupon" class="coupon"></div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="info-row">
                                            <div>Discount Value</div>
                                            <div class="discount-val">$0.00</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif


                        {{ csrf_field() }}
                        @if(session('error'))
                            <div class="alert alert-danger">
                                <i class="icon-exclamation-circle"></i>Payment was declined, please check your payment
                                method and try again.
                            </div>
                        @endif
                        <div class="form-group text-center">
                            <button type="submit" class="button button-3d">
                                <i class="icon-check"></i> Pay <span
                                    class="total-pay-btn">${{ round($totalAmount, 2) }}</span> and reactivate
                                subscription
                            </button>
                        </div>
                    </form>

                    <div style="display: flex; justify-content: center; margin-top: 60px">
                        <div class="AuthorizeNetSeal">
                            <script>
                                var ANS_customer_id = "74b69157-09b2-4e1c-93f6-ccc5a557ae48";
                            </script>
                            <script src="https://verify.authorize.net:443/anetseal/seal.js"></script>
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

    @if(isset($result))
        <div class="subsCanceledPopupWrapper">
            <div class="subsCanceledPopup">
                <div class="subsCanceledPopup-close">
                    <img src="{{ asset('assets/images/close.png') }}" alt="close">
                </div>
                <div class="subsCanceledPopup-title">Your subscription was canceled</div>
                <div class="subsCanceledPopup-text">Your paid period runs out
                    at {{ $subscription->should_cancel_at->format('Y-m-d') }}. After this date you won't have rights to
                    use videos licensed through our service.
                    To reactivate your subscription at any time go to Account Settings.
                </div>
                <div class="subsCanceledPopup-closebtn">
                    OK
                </div>
            </div>
        </div>
    @endif

@endsection

@section('css_additional')
    <style>

        .discounted {
            color: green;
        }

        .coupon {
            margin-bottom: 10px;
            text-align: right;
        }

        .typeSelect {
            margin-bottom: 10px;
            padding: 5px 0;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            border-bottom: dotted 1px gray;
            margin-bottom: 20px;
        }

        .section-row {
            justify-content: space-between;
            font-weight: 700;
            margin-bottom: 10px;
        }

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

        $('.typeSelect').change(function () {
            $('.coupon').val('')
            const type = $(this).val()
            // alert(type)
            $.ajax({
                type: "POST",
                url: "/subscription/validate",
                data: {
                    _token: '{{ csrf_token() }}',
                    plan: 1,
                    term: type,
                    coupon: $('.coupon').val(),
                    state_code: '{{ $user->state }}'
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data)
                    $('.info-row-total').html('$' + data.total);
                    $('.total-pay-btn').html('$' + data.total);
                    $('.info-row-price').html('$' + data.origSubTotal);
                    $('.info-row-tax').html('$' + data.tax);
                    $('.info-row-discount').html('$' + data.couponValue);
                    $('.discount-val').html('$' + data.couponValue);
                    if (Number(data.couponValue) === 0.00) {
                        $('.info-row-discount').addClass('discounted');
                        $('.discount-val').addClass('discounted');
                    } else {
                        $('.info-row-discount').removeClass('discounted');
                        $('.discount-val').removeClass('discounted');
                    }
                },
                error: function (err) {
                    // confirmBtnLoading = false
                    // $('.confirm-btn').html('CONFIRM ORDER')
                    // console.log(err)
                }
            })
        })

        let couponLoadingInterval = null
        $('.coupon').keyup(function () {
            if (couponLoadingInterval) {
                clearTimeout(couponLoadingInterval)
            }
            couponLoadingInterval = setTimeout(function () {
                confirmBtnLoading = true
                couponValue = null
                const type = $('.typeSelect').val()
                $.ajax({
                    type: "POST",
                    url: "/subscription/validate",
                    data: {
                        _token: '{{ csrf_token() }}',
                        plan: 1,
                        term: type,
                        coupon: $('.coupon').val(),
                        state_code: '{{ $user->state }}'
                    },
                    dataType: 'json',
                    success: function (data) {
                        $('.info-row-total').html('$' + data.total);
                        $('.total-pay-btn').html('$' + data.total);
                        $('.info-row-price').html('$' + data.origSubTotal);
                        $('.info-row-tax').html('$' + data.tax);
                        $('.info-row-discount').html('$' + data.couponValue);
                        $('.discount-val').html('$' + data.couponValue);
                        if (Number(data.couponValue) === 0.00) {
                            console.log('000')
                            $('.info-row-discount').removeClass('discounted');
                            $('.discount-val').removeClass('discounted');
                        } else {
                            $('.info-row-discount').addClass('discounted');
                            $('.discount-val').addClass('discounted');
                        }
                    },
                    error: function (err) {
                        // confirmBtnLoading = false
                        // $('.confirm-btn').html('CONFIRM ORDER')
                        // console.log(err)
                    }
                })
            }, 500)
        })


        let tocConfirmed = false;
        $(document).ready(function () {
            $('.subsCanceledPopup-closebtn').click(function () {
                $('.subsCanceledPopupWrapper').css('display', 'none')
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
