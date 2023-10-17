@extends('template.layout')

@section('title', 'Dashboard | ' . config('app.name'))

@section('description', 'Your account and settings')

@section('content')

    <div class="content-wrap">
        <div class="container clearfix">
            <div class="row clearfix">
                <div class="col-md-9">
                    <div class="heading-block border-0">
                        <h3 style="text-align: center; font-size: 28px; margin-top: 60px;">Your subscription is reactivated!</h3>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="final-modal-wrapper">
                        <div class="final-modal" style="background-image: url({{  asset('assets/images/signup/final.gif') }})">
                            <div>
                                <div class="final-modal-title">Your subscription is reactivated!</div>
                                <div class="final-modal-text">Now lets get your video licensed.</div>
                            </div>
                            <a class="final-modal-btn button button-3d" href="{{ route('public.gallery') }}">GALLERY</a>
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
