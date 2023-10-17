@extends('template.layout')

@section('title', 'Gallery | Just Share Media')
{{--@section('title', 'Gallery | ' . config('app.name'))--}}

@section('description', 'Browse through some of our creations and experience what we can provide for you.')

@section('css_additional')
    <style>
        .discounted {
            color: green;
        }

        .licenseBannerWrapper {
            position: relative;
            width: 850px;
            height: 57px;
            margin: 0 auto;
            text-align: center;
            margin-top: 3em;
            padding: 15px 0;
            background: rgba(20, 119, 251, 0.1);
            border: 1px solid rgba(20, 119, 251, 0.15);
            border-radius: 4px;
        }
        .lb-infoIcon {
            width: 60px;
            float: left;
            border-right: solid 1px #C7DFFE;
            margin-right: 25px;
        }
        .lb-text {
            float: left;
            font-family: 'Poppins';
            font-size: 18px;
        }
        .lb-close {
            position: absolute;
            right: -32px;
            top: -10px;
            float: right;
            width: 22px;
            height: 22px;
            background: #6C757C;
            text-align: center;
            cursor: pointer;
            border-radius: 50%;
            margin-right: 20px;
        }
        .lb-close img {
            margin-bottom: 6px;
        }

        .explain_modal_ok, .additional_video_existing_payment, .additional_video_new_payment, .maxvideos_modal_ok {
            display: block;
            color: white;
        }
        .explain_modal_ok:hover, .additional_video_existing_payment:hover, .additional_video_new_payment:hover, .maxvideos_modal_ok:hover {
            display: block;
            color: white;
        }
        .additional_video_modal {
            color: white;
            font-weight: bold;

        }
    </style>

    <style>
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
        .confirmationPopup-close, .explainPopup-close, .maxvideos_modal-close {
            position: absolute;
            right: 20px;
            top: 20px;
            cursor: pointer;
        }
        .confirmationPopup-title {
            font-family: Poppins;
            font-weight: 600;
            font-size: 18px;
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
            padding: 10px 0 10px 0;
            border-radius: 6px;
            cursor: pointer;
            font-family: Lato;
            font-weight: 500;
            font-size: 20px;
        }
    </style>
@endsection

@section('content')
    <section id="page-title" class='page-title-mini'>
        <div class="container clearfix">
            <h1>Gallery</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Gallery</li>
            </ol>
        </div>
    </section>

    @if(Auth::user() && $subscription)
        @if($subscription->status != 'canceled')
            @if($hasUnusedAdditionalVideo)
                <div class="licenseBannerWrapper" style="height: 80px">
                    <div class="lb-infoIcon">
                        <img src="{{url('/assets/images/gallery/lb-info-icon.png')}}" alt="">
                    </div>
                    <div class="lb-text" style="width: calc(100% - 105px);">
                        <b>You have purchased an additional video but didn't license it.</b><br>
                        <a href="{{ route('video.customize', ['id' => $hasUnusedAdditionalVideo->video_id, 'type' => 'additional']) }}">Click here to do it now.</a>
                    </div>
                </div>
            @endif
            @php
                @endphp
            @if($daysLeftUntilNewLicense > 0)
                <div class="licenseBannerWrapper">
                    <div class="lb-infoIcon">
                        <img src="{{url('/assets/images/gallery/lb-info-icon.png')}}" alt="">
                    </div>
                    <div class="lb-text">You have <b>{{ $daysLeftUntilNewLicense }}</b> day{!! $daysLeftUntilNewLicense > 1 ? 's' : '' !!} until your next license is available.
                        <a href="#" class="explainPopup">Buy an additional license now</a>
                    </div>
                    <div class="lb-close"><img src="{{url('/assets/images/gallery/lb-close-icon.svg')}}" alt=""></div>
                </div>
            @endif
            @if($daysLeftUntilNewLicense === -9999)
                <div class="licenseBannerWrapper">
                    <div class="lb-infoIcon">
                        <img src="{{url('/assets/images/gallery/lb-info-icon.png')}}" alt="">
                    </div>
                    <div class="lb-text">Your subscription is processing, please try again in a minute and refresh your page.</div>
                    <div class="lb-close"><img src="{{url('/assets/images/gallery/lb-close-icon.svg')}}" alt=""></div>
                </div>
            @endif
            @if($daysLeftUntilNewLicense === -99999)
                <div class="licenseBannerWrapper">
                    <div class="lb-infoIcon">
                        <img src="{{url('/assets/images/gallery/lb-info-icon.png')}}" alt="">
                    </div>
                    <div class="lb-text">You have unpaid subscription, please go to <a href="{{ route('my-subscriptions.index') }}">subscription page</a>.</div>
                    <div class="lb-close"><img src="{{url('/assets/images/gallery/lb-close-icon.svg')}}" alt=""></div>
                </div>
            @endif
        @else
{{--     Subscription canceled       --}}
            <div class="licenseBannerWrapper" style="height: 80px; justify-content: center; align-items: center; display: flex;">
                <div class="lb-infoIcon">
                    <img src="{{url('/assets/images/gallery/lb-info-icon.png')}}" alt="">
                </div>
                <div class="lb-text" style="width: calc(100% - 105px);">
                    <b>Your subscription is canceled, reactivate it <a href="{{ route('subscriptions.reactivate') }}">here</a> anytime.</b>
{{--                    <br>--}}
{{--                    <a href="{{ route('') }}">Reactivate</a>--}}
                </div>
            </div>
        @endif

    @endif

    <section id="how-it-works" class="row mt-5">
        <div class="container clearfix">
            <div class="col-12">
                <div id="portfolio" class="portfolio row" data-layout="fitRows">
                    <article class="portfolio-item col-md-4 col-sm-6 col-12 pf-video">
                        <div class="how-it-works-img">
                            <img src="{{asset('/assets/images/gallery/youtube.svg')}}"/>
                        </div>
                        <div class="how-it-works-header mt-6">1. Choose a video</div>
                        <p class="mt-2">
                            Our algorithm makes sure that other local roofing companies are not using the same videos as
                            you to maximize the return on your investment.
                        </p>
                    </article>
                    <article class="portfolio-item col-md-4 col-sm-6 col-12 pf-video">
                        <div class="how-it-works-img">
                            <img src="{{asset('/assets/images/gallery/template.svg')}}"/></div>
                        <div class="how-it-works-header mt-6">2. Choose a template</div>
                        <p class="mt-2">
                            Choose from a variety of pre- built templates to get your message across. We have
                            extensively tested each template so you don’t have to guess what works best.
                        </p>
                    </article>
                    <article class="portfolio-item col-md-4 col-sm-6 col-12 pf-video">
                        <div class="how-it-works-img">
                            <img src="{{asset('/assets/images/gallery/export.svg')}}"/></div>
                        <div class="how-it-works-header mt-6">3. Export your video</div>
                        <p class="mt-2">
                            Export your video and you are ready to begin marketing your company!
                        </p>
                    </article>
                </div>
            </div>
        </div>
    </section>
    <div id="galleryitems" class="section m-0 bg-transparent">
        <div class="container clearfix">
            <div class="heading-block center">
                <h2>Gallery Items</h2>
            </div>
            <div class="under-heading-block center">
                <span class="">Choose from one of the following videos.</span>
            </div>
            @if(\Auth::check())
                <div class="filters">
                    <div class="row">
                        <div class="col-6 center">
                            <select id="locations" class="selectpicker" multiple onchange="selectedLocations()"
                                    data-actions-box="true">
                                @foreach($locations as $location)
                                    @if($loop->first)
                                        <option value="{{$location->id}}"
                                                selected="selected">{{$location->address}}</option>
                                    @else
                                        <option value="{{$location->id}}">{{$location->address}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 center">
                            <select id="shingle-types" class="selectpicker" multiple onchange="shingleTypes()"
                                    data-actions-box="true">
                                @foreach($shingleTypes as $shingleType)
                                    <option value="{{$shingleType->shingle_type}}"
                                            selected="selected">{{$shingleType->shingle_type}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row" id="gallery-content"></div>

            <div class="line center"></div>
            <div class="row">
                <div class="col-12 center">
                    <button id="load-more" class="load-more-button"><span>Load more</span></button>
                </div>
            </div>
            <div id="loader">
                <div class="spinner-border" style="" role="status"><span class="sr-only">Loading...</span></div>
            </div>
        </div>
    </div>
    <x-section-call-to-action/>


    <div id="additional_video_modal" class="confirmationPopupWrapper" style="display: none;">
        <div class="confirmationPopup">
            <div class="confirmationPopup-close">
                <img src="{{ asset('assets/images/close.png') }}" alt="close">
            </div>
            <div class="confirmationPopup-title">Your  next license will be available on {{ $newLicenseAvailableAt ?? '' }}</div>
            <div class="confirmationPopup-text">Would you like to purchase an additional license for $399?</div>
            <div class="confirmationPopup-closebtn yes_additional_video_modal">
                <span>Yes, license this video</span>
            </div>
            <div class="confirmationPopup-cancelbtn close_additional_video_modal">
                <span class="">No, I'll wait</span>
            </div>
        </div>
    </div>

    @if(\Auth::check())
    @php
        $fmt = new NumberFormatter( 'us_US', NumberFormatter::CURRENCY );
    @endphp
    <div id="payment_additional_video_modal" class="confirmationPopupWrapper" style="display: none;">
        <div class="confirmationPopup">
            <div class="confirmationPopup-close">
                <img src="{{ asset('assets/images/close.png') }}" alt="close">
            </div>
            <div class="confirmationPopup-title">Would you like to charge the card on file?</div>
            <div class="confirmationPopup-text">
                Card {!! \Auth::user() ? substr(\Auth::user()->cardnumber, -4) : '' !!}
                <br>
                <br>
                Video: <span id="ap_video_title"></span>
                <br>
                Price: <span class="ad-price">{{ $fmt->formatCurrency(399, 'USD') }}</span>
                <br>
                Discount: <span class="ad-discount">{{ $fmt->formatCurrency(0, 'USD') }}</span>
                <br>
                Tax: <span class="ad-tax">{{ number_format(\App\Models\TaxRate::getTaxRate(\Auth::user()->state), 2) }}%</span>
                <br>
                <b>Total: </b><span class="ad-total">{{ $fmt->formatCurrency(399 + \App\Models\TaxRate::getTaxRate(\Auth::user()->state), 'USD') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <label style="margin: 0" for="">Coupon code</label>
                <input class="confirmationPopup-coupon" type="text">
            </div>
            <div class="confirmationPopup-closebtn">
                <a href="" class="additional_video_existing_payment">Yes, charge this card</a>
            </div>
            <div class="confirmationPopup-closebtn">
                <a href="" class="additional_video_new_payment">No, new payment method</a>
            </div>
        </div>
    </div>
    @endif

    <div id="explain_modal" class="confirmationPopupWrapper" style="display: none;">
        <div class="confirmationPopup">
            <div class="explainPopup-close">
                <img src="{{ asset('assets/images/close.png') }}" alt="close">
            </div>
            <div class="confirmationPopup-title">To buy additional videos, click the <b>Edit Video</b> button on the video you’d like to purchase below</div>
            <div class="confirmationPopup-closebtn">
                <a href="#" class="explain_modal_ok">OK</a>
            </div>
        </div>
    </div>

    <div id="maxvideos_modal" class="confirmationPopupWrapper" style="display: none;">
        <div class="confirmationPopup">
            <div class="maxvideos_modal-close">
                <img src="{{ asset('assets/images/close.png') }}" alt="close">
            </div>
            <div class="confirmationPopup-title">Oops, the max amount of additional videos you can buy per month is 4, please wait until next month to buy more!</div>
            <div class="confirmationPopup-closebtn">
                <a href="#" class="maxvideos_modal_ok">OK</a>
            </div>
        </div>
    </div>

@endsection

@section('js_additional')
    <script type="text/javascript">
        let existingPaymentBaseUrl = '';
        let couponLoadingInterval = null
        $('.confirmationPopup-coupon').keyup(function () {
            if (couponLoadingInterval) {
                clearTimeout(couponLoadingInterval)
            }
            couponLoadingInterval = setTimeout(function () {
                confirmBtnLoading = true
                couponValue = null
                $.ajax({
                    type: "POST",
                    url: "/validate-coupon/additional",
                    data: {
                        _token: '{{ csrf_token() }}',
                        coupon: $('.confirmationPopup-coupon').val(),
                    },
                    dataType: 'json',
                    success: function (data) {
                        $('.ad-total').html(data.data.total);
                        $('.ad-price').html(data.data.price);
                        $('.ad-tax').html(data.data.tax);
                        $('.ad-discount').html(data.data.discount);
                        if(data.status) {
                            $('.ad-discount').addClass('discounted');
                            $('.additional_video_existing_payment').attr('href', existingPaymentBaseUrl + '?coupon=' + $('.confirmationPopup-coupon').val())
                        } else {
                            $('.ad-discount').removeClass('discounted');
                            $('.additional_video_existing_payment').attr('href', existingPaymentBaseUrl)
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

        $('.explainPopup').click(function() {
            $('#explain_modal').css({
                'display': 'flex'
            })
        })
        $('.explain_modal_ok').click(function() {
            $('#explain_modal').css({
                'display': 'none'
            })
        })
        $('.explainPopup-close').click(function() {
            $('#explain_modal').css({
                'display': 'none'
            })
        })

        let selectedVideo = 0;
        let selectedVideoTitle = '';
        const baseUrl = '{{ URL::to('/') }}';


        $('.confirmationPopup-close').click(function() {
            $('#additional_video_modal').css({
                display: 'none'
            })
            $('#payment_additional_video_modal').css({
                display: 'none'
            })
        })

        $('.maxvideos_modal_ok').click(function (){
            $('#maxvideos_modal').css({
                'display': 'none'
            })
        })
        $('.maxvideos_modal-close').click(function (){
            $('#maxvideos_modal').css({
                'display': 'none'
            })
        })

        @if(\Illuminate\Support\Facades\Auth::check())
        const alreadyLicensedNumber = {{ \App\Models\AdditionalLicense::where('created_at', '>=', \Illuminate\Support\Carbon::now()->subDays(30)->toDateTimeString())->where('user_id', \Illuminate\Support\Facades\Auth::user()->id)->count() }}
        @endif
        $(document).on('click', '.additional_video_modal', function () {
            selectedVideo = $(this).data('videoid')
            selectedVideoTitle = $(this).data('videotitle')
            if(alreadyLicensedNumber > 3) {
                $('#maxvideos_modal').css({
                    'display': 'flex'
                })
            } else {
                $('#additional_video_modal').css({
                    display: 'flex'
                })
            }
        })

        $('.close_additional_video_modal').click(function () {
            $('#additional_video_modal').css({
                display: 'none'
            })
        })

        $('.yes_additional_video_modal').click(function () {
            $('#additional_video_modal').css({
                display: 'none'
            })
            existingPaymentBaseUrl = baseUrl + '/additional-license/video/' + selectedVideo;
            $('.additional_video_existing_payment').attr('href', existingPaymentBaseUrl)
            $('.additional_video_new_payment').attr('href', baseUrl + '/additional-license/payment/video/' + selectedVideo)
            $('#ap_video_title').html(selectedVideoTitle)
            $('#payment_additional_video_modal').css({
                display: 'flex'
            })
        })

        let page = 1;
        let types = [];
        let locations = [];
        let isInitialAjaxGalleryRequest = 1;


        $(document).ready(function () {
            @if(\Auth::check())
            galleryAjax();
            @else
            galleryGuestAjax();
            @endif

            $(document).on('click', '#load-more', function () {
                @if(\Auth::check())
                galleryAjax(page++);
                @else
                galleryGuestAjax(page++);
                @endif
            });
        });

        function shingleTypes() {
            page = 1;
            isInitialAjaxGalleryRequest = 1
            $('#gallery-content').html('');
            galleryAjax(page);
        }

        function selectedLocations() {
            page = 1;
            isInitialAjaxGalleryRequest = 1
            $('#gallery-content').html('');
            galleryAjax(page);
        }
        @if(\Auth::check())
        $('.lb-close').click(function() {
            $('.licenseBannerWrapper').hide();
        })
        function galleryAjax() {
            types = $('#shingle-types').selectpicker('val');
            locations = $('#locations').selectpicker('val');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                url: '{{route('gallery.ajax')}}',
                type: 'POST',
                data: {
                    page: page,
                    types: types,
                    locations: locations,
                    isInitialAjaxGalleryRequest: isInitialAjaxGalleryRequest
                },
                success: function (response) {
                    if (typeof response.last_page !== typeof undefined) {
                        if (page >= response.last_page) {
                            $('#load-more').hide();
                        } else {
                            $('#load-more').show();
                        }
                    }
                    $('#gallery-content').append(response.html);
                    isInitialAjaxGalleryRequest = 0;
                    //$('#loader').hide();
                },
                error: function (error) {
                    console.log(error);
                    //$('#loader').hide();
                },
                beforeSend: function () {
                    //$('#loader').show();
                },
            });
        }
        @else
        function galleryGuestAjax() {

            $.ajax({
                url: '{{route('gallery.guest.ajax')}}',
                type: 'POST',
                data: {
                    page: page,
                    isInitialAjaxGalleryRequest: isInitialAjaxGalleryRequest
                },
                success: function (response) {
                    if (typeof response.last_page !== typeof undefined) {
                        if (page >= response.last_page) {
                            $('#load-more').hide();
                        } else {
                            $('#load-more').show();
                        }
                    }
                    $('#gallery-content').append(response.html);
                    isInitialAjaxGalleryRequest = 0;
                    //$('#loader').hide();
                },
                error: function (error) {
                    console.log(error);
                    //$('#loader').hide();
                },
                beforeSend: function () {
                    //$('#loader').show();
                },
            });
        }
        @endif

    </script>
@endsection
