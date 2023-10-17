@extends('template.layout')

@section('title', 'Additional video payment | Just Share Media')
{{--@section('title', 'About Us | Just Share Roofing Media')--}}

@section('description', 'Additional video payment')

@section('css_additional')
    <style>
        .discounted {
            color: green;
        }
    </style>
@endsection


@section('content')

    <section id="page-title" class='page-title-mini'>
        <div class="container clearfix">
            <h1>Additional video payment</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Additional video payment</li>
            </ol>
        </div>
    </section>

    <div class="content-wrap py-0">

        <div class="section bg-transparent m-0" id='services'>

            <div class="container">

                <form class="js-validation-signin" method="POST"
                      action="{{ route('chargeForAdditionalVideo', ['video' => $video]) }}">
{{--                    <input type="hidden" name="video" value="{{  }}">--}}
                    @csrf

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="text" name="first_name"
                                                   class="form-control @error('first_name') is-invalid @enderror"
                                                   placeholder="Cardholder First Name">
                                            <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="icon-credit-card"></i>
                                                    </span>
                                            </div>
                                            @error ('first_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="text" name="last_name"
                                                   class="form-control @error('last_name') is-invalid @enderror"
                                                   placeholder="Cardholder Last Name">
                                            <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="icon-credit-card"></i>
                                                    </span>
                                            </div>
                                            @error ('last_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <div class="input-group">
                                    <input type="number" name="card_number"
                                           class="form-control @error('card_number') is-invalid @enderror"
                                           placeholder="Card Number">
                                    <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="icon-credit-card"></i>
                                                    </span>
                                    </div>
                                    @error ('card_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <select name="exp_month" class="custom-select @error('exp_month') is-invalid @enderror">
                                                <option value="0">Expiration Month</option>
                                                <option value="01">January</option>
                                                <option value="02">February</option>
                                                <option value="03">March</option>
                                                <option value="04">April</option>
                                                <option value="05">May</option>
                                                <option value="06">June</option>
                                                <option value="07">July</option>
                                                <option value="08">August</option>
                                                <option value="09">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select>
                                            <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <i class="icon-calendar"></i>
                                                            </span>
                                            </div>
                                            @error ('exp_month')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <select name="exp_year" id="exp_year" class="custom-select @error('exp_year') is-invalid @enderror">
                                                <option value="0">Expiration Year</option>
                                            </select>
                                            <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <i class="icon-calendar"></i>
                                                            </span>
                                            </div>
                                            @error ('exp_year')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="number" name="cvv"
                                                   class="form-control @error('cvv') is-invalid @enderror"
                                                   placeholder="CVV">
                                            <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="icon-key"></i>
                                                        </span>
                                            </div>
                                            @error ('cvv')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <div class="input-group">
                                    <input type="text" name="coupon"
                                           class="coupon form-control @error('coupon') is-invalid @enderror"
                                           placeholder="Coupon Code">
                                    <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="icon-credit-card"></i>
                                                    </span>
                                    </div>
                                    @error ('coupon')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        $fmt = new NumberFormatter( 'us_US', NumberFormatter::CURRENCY );
                    @endphp
                    <div>
                        Video: {{ $video->title }}
                        <br>
                        Price: <span class="ad-price">{{ $fmt->formatCurrency(399, 'USD') }}</span>
                        <br>
                        Discount: <span class="ad-discount">$ 0</span>
                        <br>
                        Tax: <span class="ad-tax">{{ number_format(\App\Models\TaxRate::getTaxRate(\Auth::user()->state), 2) }} %</span>
                        <br>
                        <b>Total: </b><span class="ad-total">{{ $fmt->formatCurrency(399 + 399 / 100 * \App\Models\TaxRate::getTaxRate(\Auth::user()->state), 'USD') }}</span>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="button button-3d">
                            <i class="icon-check"></i> Pay <span class="ad-total">{{ $fmt->formatCurrency(399 + 399 / 100 * \App\Models\TaxRate::getTaxRate(\Auth::user()->state), 'USD')}}</span>
                        </button>
                    </div>
                </form>

                <div style="display: flex; justify-content: center;">
                    <div class="AuthorizeNetSeal">
                        <script>
                            var ANS_customer_id="74b69157-09b2-4e1c-93f6-ccc5a557ae48";
                        </script>
                        <script src="https://verify.authorize.net:443/anetseal/seal.js"></script>
                    </div>
                </div>
            </div>

        </div>


    </div>

@endsection

@section('js_additional')
    <script>

        let couponLoadingInterval = null
        $('.coupon').keyup(function () {
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
                        coupon: $('.coupon').val(),
                    },
                    dataType: 'json',
                    success: function (data) {
                        $('.ad-total').html(data.data.total);
                        $('.ad-price').html(data.data.price);
                        $('.ad-tax').html(data.data.tax);
                        $('.ad-discount').html(data.data.discount);
                        if(data.status) {
                            $('.ad-discount').addClass('discounted');
                        } else {
                            $('.ad-discount').removeClass('discounted');
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


        let state_code = '';
        let key = '{{config('services.google.key')}}';
        let addressField;
        let geocoder;

        window.onload = function() {
            // Generate form field years
            generateYears();
            initGeocode();
        }

        // Generate credit card year selections
        function generateYears()
        {
            let year = new Date().getFullYear();
            for (var i = 0; i <= 15; i++) {
                document.getElementById('exp_year').innerHTML += "<option value='" + year + "'>" + year + "</option>";
                year++;
            }
        }

        function codeAddress() {

            //In this case it gets the address from an element on the page, but obviously you  could just pass it to the method instead
            //let address = document.getElementById( 'address' ).value;

            geocoder.geocode({'address': addressField.value}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {

                    $('#state option:first').prop('selected', true)
                    $('#city').val('')
                    $('#zip').val('')
                    for(let i=0; i < results[0].address_components.length; i++) {
                        if(results[0].address_components[i].types.includes('administrative_area_level_1')) {
                            $('#state option[value="' + results[0].address_components[i].short_name + '"]').prop('selected', true)
                        }
                        if(results[0].address_components[i].types.includes('locality')) {
                            $('#city').val(results[0].address_components[i].long_name)
                        }
                        if(results[0].address_components[i].types.includes('postal_code')) {
                            $('#zip').val(results[0].address_components[i].long_name)
                        }
                    }

                } else {
                    console.log('Geocode was not successful for the following reason: ' + status)
                }
            });
        }

        function initGeocode(){
            addressField = document.getElementById("address");
            geocoder = new google.maps.Geocoder();
            // Create the autocomplete object, restricting the search predictions to
            // addresses in the US.
            autocomplete = new google.maps.places.Autocomplete(addressField, {
                componentRestrictions: {country: ["us", "ua"]},
                fields: ["address_components", "geometry"],
                types: ["address"],
            });
            //addressField.focus();
            // When the user selects an address from the drop-down, populate the
            // address fields in the form.
            autocomplete.addListener("place_changed", fillInAddress);
        }

        function fillInAddress() {
            // Get the place details from the autocomplete object.
            const place = autocomplete.getPlace();
            let address = "";

            // Get each component of the address from the place details,
            // and then fill-in the corresponding field on the form.
            // place.address_components are google.maps.GeocoderAddressComponent objects
            // which are documented at http://goo.gle/3l5i5Mr

            for (const component of place.address_components) {
                const componentType = component.types[0];
                console.log(componentType);
                switch (componentType) {
                    case "street_number": {
                        address = `${component.long_name} ${address}`;
                        break;
                    }

                    case "route": {
                        address += component.short_name;
                        break;
                    }
                }
            }
            //addressField.value = address;
            codeAddress();
        }

    </script>
    <script async
            src="https://maps.googleapis.com/maps/api/js?key={{config('services.google.key')}}&libraries=places&callback=initGeocode">
    </script>
@endsection
