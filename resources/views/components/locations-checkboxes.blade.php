@foreach($locations as $location)
    @if($drawAll || \App\Models\LicensedVideo::hasFreeLocation($user) || !$loop->first)
        <div class="col mb-5 d-flex flex-row">
            <div class="ml-2 row w-100 d-flex align-items-center">
                <input name="additional_location[]" class="choose-location-additional-locations-checkbox" type="checkbox" value="{{$location->id}}">
                <span class="choose-location-additional-locations-location">{{$location->address}}</span>
            </div>
            <span class="choose-location-additional-locations-location-price">${{config('app.additional_location_license_amount')}}</span>
        </div>
    @endif
@endforeach
