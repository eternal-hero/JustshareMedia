@extends('template.layout')

@section('title', 'Video customization | ' . config('app.name'))

@section('description', 'Discover who we are, our mission, and what we can provide to your business.')

@section('content')
    <section id="page-title" class='page-title-mini make-padding-smaller'>

    </section>
    <div class="section bg-transparent m-0" id='services'>
        <div class="container choose-location-wrapper-helper">
            <div class="heading-block center line-none">
                <img class="location-label-image" src="{{ asset('images/location-label.svg') }}" alt="">
                <h2>Choose location for your video</h2>
            </div>
            @if($locations)
                <form id="attach-location-form">
                    @csrf
                    <input type="hidden" name="saved_card" id="saved-card" value="0"/>
                    <input type="hidden" name="video_id"  value="{{$video_id}}"/>
                    <input type="hidden" name="licence_type"  value="{{$licenseType}}"/>
                    <div class="row d-flex flex-column choosing-window">

                        <div class="col">
                            <div
                                class="row d-flex flex-column justify-content-center align-items-center text-center px-6 pb-2">
                                @if(!\App\Models\LicensedVideo::hasFreeLocation($user))
                                <div class="col">
                                    <h4 class="choose-location-title">Choose one location for FREE</h4>
                                    <select id="location-dropdown" name="free_location" class="choose-location-select">
                                        @foreach($locations as $location)
                                            @if($loop->first)
                                                <option class="choose-location-select choose-location-select-option"
                                                        value="{{ $location->id }}"
                                                        selected>{{ $location->address }}</option>
                                            @else
                                                <option class="choose-location-select choose-location-select-option"
                                                        value="{{ $location->id }}">{{ $location->address }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div
                                    class="col choose-location-additional-locations d-flex flex-column align-items-center">
                                    <h4 class="choose-location-additional-locations-title">Add additional locations</h4>
                                    <div class="row w-100 d-flex flex-column" id="additional-location-ajax">
                                        @include('components.locations-checkboxes')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col choose-location-total-amount d-flex justify-content-center align-items-center">
                            <div
                                class="row d-flex flex-row px-4 justify-content-between choose-location-total-amount-block">
                                <span class="choose-location-total-amount-block-title">Total amount</span>
                                <span class="choose-location-total-amount-block-total-price" id="total-amount">$0</span>
                            </div>
                        </div>
                    </div>

                    <div id="payment-details" style="display: none">

                        @if($user->cardnumber != '' && $user->authorize_customer_id != '' && $user->authorize_customer_payment_profile_id)

                            <div class="row choosing-window second saved-card">
                                <div class="col">
                                    <div class="row justify-content-center">
                                        <button id="saved-card-pay" class="submit-button">Pay with saved card
                                            ***{{substr($user->cardnumber, -4)}}</button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="heading-block center">
                            <img class="location-label-image" src="{{ asset('images/cards.svg') }}" alt="">
                            <h2 class="main-page-title">Add your payment information</h2>
                        </div>
                        <div class="row choosing-window second">
                            <div class="col">
                                <div
                                    class="row d-flex flex-column justify-content-center align-items-center text-center px-6 pb-2">
                                    <div class="col">
                                        <h4 class="choose-location-title">Enter your credit card</h4>
                                        <input name="cardnumber" id="cardnumber" type="text" placeholder="Card number" maxlength="16"
                                               class="form-control choose-location-input mx-auto">
                                    </div>
                                    <div
                                        class="col choose-location-additional-locations-payment second px-0 d-flex flex-column align-items-center">
                                        <h4 class="choose-location-additional-locations-title exp-date">Expiration
                                            date</h4>
                                        <div class="row w-100 d-flex flex-row justify-content-between">
                                            <div class="col p-0 exp-date-column">
                                                <select name="expmonth" id="expmonth"
                                                        class="form-control choose-location-select-date">
                                                    <option class="choose-location-select-date-option" value=''>---
                                                    </option>
                                                    <option class="choose-location-select-date-option" value='01'>01 -
                                                        January
                                                    </option>
                                                    <option class="choose-location-select-date-option" value='02'>02 -
                                                        February
                                                    </option>
                                                    <option class="choose-location-select-date-option" value='03'>03 -
                                                        March
                                                    </option>
                                                    <option class="choose-location-select-date-option" value='04'>04 -
                                                        April
                                                    </option>
                                                    <option class="choose-location-select-date-option" value='05'>05 -
                                                        May
                                                    </option>
                                                    <option class="choose-location-select-date-option" value='06'>06 -
                                                        June
                                                    </option>
                                                    <option class="choose-location-select-date-option" value='07'>07 -
                                                        July
                                                    </option>
                                                    <option class="choose-location-select-date-option" value='08'>08 -
                                                        August
                                                    </option>
                                                    <option class="choose-location-select-date-option" value='09'>09 -
                                                        September
                                                    </option>
                                                    <option class="choose-location-select-date-option" value='10'>10 -
                                                        October
                                                    </option>
                                                    <option class="choose-location-select-date-option" value='11'>11 -
                                                        November
                                                    </option>
                                                    <option class="choose-location-select-date-option" value='12'>12 -
                                                        December
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col p-0 exp-date-column">
                                                <select name="expyear" id="expyear" class="choose-location-select-date form-control">
                                                    <option class="choose-location-select-date-option" value=''>---
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col p-0 exp-date-column">
                                                <input name="cvv" id="cvv" type="text" placeholder="CVV"
                                                       class="form-control choose-location-input-cvv-code">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center submit-button-wrapper">
                        <button class="submit-button" id="global-submit-button">Submit</button>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div id="undefined-error" class="mt-2 alert alert-danger" role="alert" style="display: none;">
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: center; margin-top: 60px">
                        <div class="AuthorizeNetSeal">
                            <script>
                                var ANS_customer_id="74b69157-09b2-4e1c-93f6-ccc5a557ae48";
                            </script>
                            <script src="https://verify.authorize.net:443/anetseal/seal.js"></script>
                        </div>
                    </div>

                </form>
            @else
                <div class="row d-flex flex-column choosing-window">
                    <div class="col">
                        <div
                            class="row d-flex flex-column justify-content-center align-items-center text-center px-6 pb-2">
                            <div class="col">
                                <h4 class="choose-location-title">You have no more locations to add.</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <a href="{{route('operate-locations.index')}}">
                        <button class="submit-button">Add Locations</button>
                    </a>
                </div>
            @endif
        </div>
        <div id="video-export-alert" class="modal fade" role="dialog">
            <div class="modal-dialog modal-wrapper-helper modal-position video-exporting">
                <div class="modal-content">
                    <div
                        class="modal-header text-center border-bottom-0 pb-0 modal-wrapper-helper modal-header-container">
                        <h2 class="modal-title mx-auto text-uppercase modal-wrapper-helper modal-title">Video is
                            exporting</h2>
                    </div>
                    <hr class="mx-auto my-0 modal-wrapper-helper line-under-title video-export">
                    <div class="modal-body">
                        <h3 class="modal-title text-uppercase text-danger text-center mb-3">Do not close out of this window</h3>
                        <div class="row d-flex flex-column justify-content-center px-5 text-center">
                            <p class="video-export-text">
                                Your video may take up to 5 minutes to render and download.<br>Sit back and relax, we’ll
                                notify you when it’s ready.
                            </p>
                            <img class="video-export-image-relax" src="{{ asset('images/relax.svg') }}" alt="">
                            <div class="progress">
                                <div id="progress-bar" class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="loader">
            <div class="spinner-border" style="" role="status"><span class="sr-only">Loading...</span></div>
        </div>

    </div>
@endsection
@section('js_additional')
    <script type="text/javascript">
        let progressBarWidth = 0;

        $(document).ready(function () {

            generateYears();

            $(document).on('change', '#location-dropdown', function () {
                let locationId = this.value;
                $.ajax({
                    url: '{{route('redraw.locations.checkboxes')}}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        selectedLocation: locationId,
                        videoId: {{$user->video_render_parameters['video_id']}}
                    },
                    success: function (response) {
                        $(document).find('#additional-location-ajax').html(response.html);
                    }
                });

                countCheckedLocations();
            });

            $(document).on('click', '#saved-card-pay', function () {
                $('#saved-card').val(1);
                $('#global-submit-button').trigger('click');
                return false
            });

            $(document).on('click', '#global-submit-button', function () {
                let formData = new FormData(document.getElementById('attach-location-form'));
                $('input').removeClass('is-invalid');
                $('select').removeClass('is-invalid');
                $('#undefined-error').hide();

                $.ajax({
                    url: '{{ route('add.locations')}}',
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        $('#loader').hide();
                        if (data.status) {
                            $.ajax({
                                url: '{{ route('render.video') }}',
                                type: 'POST',
                                data: {
                                    _token: '{{csrf_token()}}',
                                },
                                success: function (){
                                    window.location.href='{{route('video.ready')}}';
                                },
                                error: function (error) {
                                    console.log(error);
                                },
                                beforeSend: function () {
                                    $('#loader').hide();
                                    $('#video-export-alert').modal({
                                        'backdrop': 'static'
                                    }).show(function () {
                                        self.setInterval(function () {
                                            if (progressBarWidth > 100) {
                                                progressBarWidth = 0;
                                            }
                                            $('#progress-bar').css({
                                                'width': progressBarWidth + '%',
                                                'aria-valuenow': progressBarWidth
                                            });
                                            progressBarWidth += 10;
                                        }, 400);
                                    });
                                },
                            });

                        } else {
                            $.each(data.error, function (key, value) {
                                $('#error-list').append(value + '<br>');
                            });

                            $('#error-section').show();
                        }
                    },
                    error: function (error) {
                        $('#loader').hide();
                        console.log(error);
                        if (error.status === 422) {
                            $.each(error.responseJSON.errors, function (i, error) {
                                $('input[name="' + i + '"]').addClass('is-invalid');
                                $('select[name="' + i + '"]').addClass('is-invalid');
                            });
                        } else if (error.status === 400) {
                            $('#undefined-error').html(error.responseJSON.message).show();
                        }
                    },
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
                return false;
            });

            $(document).on('click', 'input[type="checkbox"]', function () {
                countCheckedLocations();
            });
        });

        function countCheckedLocations() {
            let $checkboxes = $(document).find('#additional-location-ajax').find('input[type="checkbox"]:checked');
            $(document).find('#total-amount').text('$' + $checkboxes.length * {{config('app.additional_location_license_amount')}});

            if ($checkboxes.length !== 0) {
                $('#payment-details').show();
                $('.submit-button-wrapper').show();

            } else {
                $('#payment-details').hide();
            }

        }

        function generateYears() {
            let year = new Date().getFullYear();
            for (var i = 0; i <= 15; i++) {
                document.getElementById('expyear').innerHTML += "<option value='" + year + "'>" + year + "</option>";
                year++;
            }
        }

    </script>
@endsection
