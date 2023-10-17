@extends('template.layout')

@section('title', 'Licensed Video | ' . config('app.name'))

@section('description', '')

@section('content')
    <section id="page-title" class='page-title-mini'>
        <div class="container clearfix">
            <h1>Video</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Location</li>
            </ol>
        </div>
    </section>
    <div class="content-wrap py-0">
        <div class="section bg-transparent m-0" id='services'>
            <div class="container">
                <div class="heading-block center">
                    <h2>Add location</h2>
                </div>
                <div class="center">
                    <h3>{{ $licensedVideo->video_title }}</h3>
                </div>
                @if($locations)
                <div class="row">
                    <div class="col-12 text-center">
                        <h4>To add more locations to current video you need additional pay
                            <b>{{config('app.additional_location_license_amount')}}$</b> per location</h4>
                        <button id="agree" class="btn btn-primary">Agree</button>
                    </div>
                </div>
                <div id="additional-payment-form" class="row mt-5" style="display: none;">
                    <form id="add-location" method="POST">
                        <input type="hidden" name="saved_card" id="saved-card" value="0"/>
                        @csrf
                        <div class="col-12">
                            <div class="row">
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <h3>Select additional location</h3>
                                            @foreach($locations as $location)
                                            <div class="custom-control custom-radio">
                                                <input
                                                    type="radio"
                                                    class="custom-control-input"
                                                    id="location-{{$location->id}}"
                                                    name="attach_video"
                                                    value="{{$user->id}},{{$video->id}},{{$location->id}}"/>
                                                <label for="location-{{$location->id}}" class="custom-control-label ">{{$location->location_name}}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8">
                                    @if($user->cardnumber != '' && $user->authorize_customer_id != '' && $user->authorize_customer_payment_profile_id)
                                    <div class="row mb-5">
                                        <div class="col-12">
                                            <button id="saved-card-pay" class="btn btn-primary">Pay with saved card ***{{substr($user->cardnumber, -4)}}</button>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-4">
                                            <h3>Payment Information</h3>
                                            <p>Enter the card details for the billing information you used above.</p>
                                            <p><img src="{{asset('/assets/images/credit-card-logos-new.png')}}"/></p>
                                        </div>
                                        <div class="col-8">
                                            <div class='row mb-0'>
                                                <div class="col-12 form-group">
                                                    <label for="cardnumber">Card Number:</label>
                                                    <input type="text" id="cardnumber" name="cardnumber" value=""
                                                           class="form-control" maxlength="16"/>
                                                </div>
                                                <div class="col-4 form-group">
                                                    <label for="cvv">CVV Code:</label>
                                                    <input type="number" id="cvv" name="cvv" value=""
                                                           class="form-control"/>
                                                </div>
                                                <div class="col-4 creditcard-expiry-month-group">
                                                    <label for="expmonth">Expiry Month:</label>
                                                    <select id="expmonth" name="expmonth" class="form-control">
                                                        <option value=''>---</option>
                                                        <option value='01'>01 - January</option>
                                                        <option value='02'>02 - February</option>
                                                        <option value='03'>03 - March</option>
                                                        <option value='04'>04 - April</option>
                                                        <option value='05'>05 - May</option>
                                                        <option value='06'>06 - June</option>
                                                        <option value='07'>07 - July</option>
                                                        <option value='08'>08 - August</option>
                                                        <option value='09'>09 - September</option>
                                                        <option value='10'>10 - October</option>
                                                        <option value='11'>11 - November</option>
                                                        <option value='12'>12 - December</option>
                                                    </select>
                                                </div>
                                                <div class="col-4 form-group">
                                                    <label for="expyear">Expiry Year:</label>
                                                    <select id="expyear" name="expyear" class="form-control">
                                                        <option value=''>---</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <input type="submit" class="btn btn-primary" value="Pay">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                    <div class="row">
                        <div class="col-12">
                            <div id="undefined-error" class="mt-2 alert alert-danger" role="alert" style="display: none;">

                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-12 text-center">
                            <h4>No location left</h4>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('js_additional')
    <script type="text/javascript">
        $(document).ready(function () {
            generateYears();

            $(document).on('click', '#agree', function () {
                $('#additional-payment-form').show();
            });

            $(document).on('click', '#saved-card-pay', function () {
                $('#saved-card').val(1);
                $('input[type="submit"]').trigger('click');
                return false
            });

            $(document).on('click', 'input[type="submit"]', function () {
                let formData = new FormData(document.getElementById('add-location'));
                $('input').removeClass('is-invalid');
                $('select').removeClass('is-invalid');
                $('#undefined-error').hide();

                $.ajax({
                    url: '{{ route('add.more.locations', $video->id) }}',
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        $('#loader').hide();
                        if (data.status) {
                            window.location.href = '{{route('licensed.videos')}}'
                        } else {
                            $('#video-preview').html('');
                            $.each(data.error, function (key, value) {
                                $('#error-list').append(value + '<br>');
                            });

                            $('#error-section').show();
                        }
                    },
                    error: function (error) {
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
        });

        function generateYears() {
            let year = new Date().getFullYear();
            for (var i = 0; i <= 15; i++) {
                document.getElementById('expyear').innerHTML += "<option value='" + year + "'>" + year + "</option>";
                year++;
            }
        }
    </script>
@endsection
