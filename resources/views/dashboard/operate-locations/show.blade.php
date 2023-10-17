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
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <h5>Name</h5>
                                        <div class="input-group">
                                            <p> {{ $operateLocation->name }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <h5>Address</h5>
                                        <div class="input-group">
                                            <p> {{ $operateLocation->address }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div id="map-wrapper">
                                        <div id="map" style="height: 300px"></div>
                                        <hr/>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col">
                                    <h2>Confirmation</h2>

                                    <form method="POST" action="{{ route('operate-locations.destroy' , $operateLocation )}}">
                                        @csrf
                                        @method('DELETE')
                                        <div class="col form-group">
                                            <button class="button button-3d m-0 button-red" type="submit" id="submit"
                                                    name="submit" value="submit">Permanently Delete Location
                                            </button>
                                            <a href='{{ route('operate-locations.index') }}'
                                               class="button button-3d button-dark">
                                                <i class="icon-arrow-left"></i> Go Back
                                            </a>
                                        </div>
                                        <input type="hidden" name="latitude" id="lat" value="{{$operateLocation->latitude}}">
                                        <input type="hidden" name="longitude" id="lng" value="{{$operateLocation->longitude}}">
                                    </form>
                                </div>
                            </div>
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
                placeMarker(event.latLng);
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
    </script>

    <script async
            src="https://maps.googleapis.com/maps/api/js?key={{config('services.google.key')}}&libraries=places&callback=initMap">
    </script>
@endsection
