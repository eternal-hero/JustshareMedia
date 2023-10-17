@extends('template.layout')

@section('title', 'Edit Operate Location | ' . config('app.name'))

@section('description', 'Managing accounts')

@section('content')

    <div class="content-wrap">
        <div class="container clearfix">
            <div class="row clearfix">
                <div class="col-md-9">
                    <div class="heading-block border-0">
                        <h3><a href='{{ route('operate-locations.index') }}'>Operate Locations</a> > {{$operateLocation->name}}</h3>
                        <span>Operate Location</span>
                    </div>
                    <div class="clear"></div>
                    <div class="row clearfix">
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

                            <form class="js-validation-signin" method="POST"
                                  action="{{ route('operate-locations.update', $operateLocation)}}">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <h5>Name</h5>
                                            <div class="input-group">
                                                <input type="text"
                                                       name="name"
                                                       value="{{ old('name') ? old('name') : $operateLocation->name }}"
                                                       class="form-control @error('name') is-invalid @enderror"
                                                >
                                                @error ('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <h5>Address</h5>
                                            <div class="input-group">
                                                <input type="text"
                                                       name="address"
                                                       id="address"
                                                       value="{{ old('address') ? old('address') : $operateLocation->address }}"
                                                       class="form-control @error('address') is-invalid @enderror"
                                                >
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i id="show-map" class="icon-location cursor-pointer"></i>
                                                    </span>
                                                </div>
                                                @error('address')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="user_id"
                                       value="{{\Illuminate\Support\Facades\Auth::user()->id}}">
                                @if ($errors->has('address'))
                                    <input type="hidden" name="latitude" id="lat" value="">
                                    <input type="hidden" name="longitude" id="lng" value="">
                                @else
                                    <input type="hidden" name="latitude" id="lat" value="{{$operateLocation->latitude}}">
                                    <input type="hidden" name="longitude" id="lng" value="{{$operateLocation->longitude}}">
                                @endif

                                <hr/>
                                <div id="map-wrapper">
                                    <div id="map" style="height: 300px"></div>
                                    <hr/>
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" class="button button-3d">
                                        <i class="icon-check"></i> Save Location
                                    </button>
                                    &nbsp;
                                    <a href='{{ route('operate-locations.index') }}' class="button button-3d button-dark">
                                        <i class="icon-arrow-left"></i> Go Back
                                    </a>
                                </div>
                            </form>
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
        let key = '{{config('services.google.key')}}';
        let map;
        let marker;
        let markers;

        let autocomplete;
        let addressField;
        let geocoder;

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 4,
                center: {lat: 40.768569, lng: -99.036924}, // center of north america, approximately
            });

            let latlng = new google.maps.LatLng(document.getElementById("lat").value, document.getElementById("lng").value);
            placeMarker(latlng);

            google.maps.event.addListener(map, 'click', function (event) {
                setLatLng(event.latLng);
                codeLatLng(event);
                placeMarker(event.latLng);
            });

            addressField = document.getElementById("address")

            addressField.onkeyup = function() {
                $('input[name="latitude"]').val('');
                $('input[name="longitude"]').val('');
            };

            // Create the autocomplete object, restricting the search predictions to
            // addresses in the US.
            autocomplete = new google.maps.places.Autocomplete(addressField, {
                componentRestrictions: {country: ["us", "ua"]},
                fields: ["formatted_address"],
                types: ["address"],
            });
            //addressField.focus();
            // When the user selects an address from the drop-down, populate the
            // address fields in the form.
            autocomplete.addListener("place_changed", fillInAddress);
            geocoder = new google.maps.Geocoder()
        }

        function setLatLng(data) {
            $('input[name="latitude"]').val(JSON.parse(data.lat()));
            $('input[name="longitude"]').val(JSON.parse(data.lng()));
        }

        function codeLatLng(event) {
            geocoder.geocode({
                'latLng': event.latLng
            }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        //alert(results[0].formatted_address);
                        $('input[name="address"]').val(results[0].formatted_address);
                    }
                }
            });
        }

        function codeAddress() {

            //In this case it gets the address from an element on the page, but obviously you  could just pass it to the method instead
            //let address = document.getElementById( 'address' ).value;

            geocoder.geocode({'address': addressField.value}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {

                    //In this case it creates a marker, but you can get the lat and lng from the location.LatLng
                    map.setCenter(results[0].geometry.location);
                    console.log(results[0].geometry.location);
                    placeMarker(results[0].geometry.location)
                    setLatLng(results[0].geometry.location);
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        }


        function placeMarker(location) {
            if (marker) {
                marker.setPosition(location);
            } else {
                marker = new google.maps.Marker({
                    position: location,
                    map: map
                });
            }
        }

        /*$(document).ready(function () {
            $('#show-map').click(function () {
                $('#map-wrapper').show(50).slideDown();
            });
        });*/

        function fillInAddress() {
            // Get the place details from the autocomplete object.
            const place = autocomplete.getPlace();
            addressField.value = place.formatted_address;
            codeAddress();
        }

    </script>

    <script async
            src="https://maps.googleapis.com/maps/api/js?key={{config('services.google.key')}}&libraries=places&callback=initMap">
    </script>
@endsection
