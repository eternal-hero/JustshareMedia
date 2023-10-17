@extends('template.layout')

@section('title', 'Billing Information | ' . config('app.name'))

@section('description', 'Update your payment method')

@section('content')

    <div class="content-wrap">
        <div class="container clearfix">

            <div class="row clearfix">

                <div class="col-md-9">

                    {{-- <img src="images/icons/avatar.jpg" class="alignleft img-circle img-thumbnail my-0" alt="Avatar" style="max-width: 84px;"> --}}

                    <div class="heading-block border-0">
                        <h3>{{ $user->name }}</h3>
                        <span>Billing Information</span>
                    </div>

                    <div class="clear"></div>

                    @if(session('error') === false)
                        <div class="alert alert-success">
                            <i class="icon-exclamation-circle"></i>Your billing information is updated.
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="icon-exclamation-circle"></i>{{ session('error') }}
                        </div>
                    @endif

                    <div class="row clearfix">
                        <div class="col-lg-12">
                            <p>Use this form to set new billing information. Your current card is: {{ $currentCreditCard }}</p>

                            <p>
                            <form class="js-validation-signin" method="POST"
                                  action="{{ route('dashboard.billing.update') }}">
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
                                                <input id="address" name="address"
                                                       class="form-control @error('address') is-invalid @enderror"
                                                       placeholder="Address"
                                                        value="{{ $user->address }}"
                                                >
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="icon-map-marker"></i>
                                                    </span>
                                                </div>
                                                @error ('address')
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
                                                        <input type="text" id="city" name="city"
                                                               placeholder="City"
                                                               value="{{ $user->city }}"
                                                               class="form-control @error('city') is-invalid @enderror"/>
                                                        <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="icon-city"></i>
                                                                </span>
                                                        </div>
                                                        @error ('city')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <select id="state" name="state" class="custom-select @error('state') is-invalid @enderror">
                                                            <option value=''>STATE</option>
                                                            @foreach($states as $state)
                                                                <option value="{{ $state['iso'] }}" {!! $state['iso'] == $user->state ? 'selected' : '' !!}>{{ $state['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="icon-flag"></i>
                                                                </span>
                                                        </div>
                                                        @error ('state')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" id="zip" name="zip"
                                                               placeholder="ZIP"
                                                               value="{{ $user->zip }}"
                                                               class="form-control @error('zip') is-invalid @enderror" />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <i class="icon-map-pin"></i>
                                                            </span>
                                                        </div>
                                                        @error ('zip')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                </div>


                                <div class="form-group text-center">
                                    <button type="submit" class="button button-3d">
                                        <i class="icon-check"></i> Update
                                    </button>

                                    <a href='{{ route('dashboard') }}' class="button button-3d button-dark">
                                        <i class="icon-arrow-left"></i> Go Back
                                    </a>
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
                            </p>

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

@section('js_additional')
    <script>
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

