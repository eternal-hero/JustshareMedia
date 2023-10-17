@extends('template.layout')

@section('title', 'My Profile | ' . config('app.name'))

@section('description', 'Update your account profile')

@section('js_additional')
    <script
            src="https://maps.googleapis.com/maps/api/js?key={{config('services.google.key')}}&libraries=places">
    </script>
    <script>
    function initAutocompleteAddress(id) {
        let element = document.getElementById(id)
        element.addEventListener("change", function(){
            element.value = "";
        });
        let autocomplete = new google.maps.places.Autocomplete(element, {
            componentRestrictions: { country: ["us"] },
            fields: ["address_components", "geometry"],
            types: ["address"],
        });
        autocomplete.addListener("place_changed", function () {
            let place = autocomplete.getPlace();
            $('#'+id).parent().children('.lat').val(place.geometry.location.lat())
            $('#'+id).parent().children('.lng').val(place.geometry.location.lng())
        });
    }

    $('.final-modal-wrapper').click(function () {
       // $('.final-modal-wrapper').hide()
    })

    $('.final-modal').click(function (e) {
        e.stopPropagation();
    })

    $(document).ready(function () {
        initAutocompleteAddress('location')
    })
</script>
@endsection

@section('content')

    <div class="content-wrap">
        <div class="container clearfix">

            <div class="row clearfix">

                <div class="col-md-9">

                    @if(!$isFullProfile)
                        <div class="alert alert-warning" style="text-align: center">
                            Please add missing details to experience the full potential of Just Share Media.
                        </div>
                    @endif

                    {{-- <img src="images/icons/avatar.jpg" class="alignleft img-circle img-thumbnail my-0" alt="Avatar" style="max-width: 84px;"> --}}

                    <div class="heading-block border-0">
                        <h3>{{ $profile->email }}</h3>
                        <span>My Profile</span>
                    </div>

                    <div class="clear"></div>

                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="icon-exclamation-circle"></i>{{ session('success') }}
                        </div>
                    @endif

                        @if (session('showPopup'))
                            <div class="final-modal-wrapper">
                            <div class="final-modal" style="background-image: url({{  asset('assets/images/signup/final.gif') }})">
                                <div>
                                    <div class="final-modal-title">Let's go!!!</div>
                                    <div class="final-modal-text">Now lets get your first video.</div>
                                </div>
                                <a class="final-modal-btn button button-3d" href="{{ route('public.gallery') }}">GALLERY</a>
                            </div>
                            </div>
                        @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            <i class="icon-exclamation-circle"></i>{{ session('error') }}
                        </div>
                    @endif

                    @if (! $errors->isEmpty())
                        <div class="alert alert-danger">
                            <i class="icon-exclamation-circle"></i><strong>Sorry!</strong> An error occurred with your
                            request. Please check your fields and try again.
                            @foreach ($errors as $error)
                                <br/>{{ $error }}
                            @endforeach
                        </div>
                    @endif

                    <div class="row clearfix">

                        <div class="col-lg-12">

                            <p>Use this form to update your account profile. This is used as your billing information
                                and should match your payment method.</p>

                            <form class="js-validation-signin" method="POST" autocomplete="off"
                                  action="{{ route('dashboard.profile.update', $profile) }}">
                                <input autocomplete="false" name="hidden" type="text" style="display:none;">
                                @csrf

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <span>First Name</span>
                                            <div class="input-group">
                                                <input type="text"
                                                       name="first_name"
                                                       value="{{ old('first_name') ? old('first_name') : $profile->first_name }}"
                                                       maxlength='64'
                                                       class="form-control @error('first_name') is-invalid @enderror"
                                                       placeholder="First Name">
                                                <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="icon-user"></i>
                                                </span>
                                                </div>
                                                @error('first_name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <span>Last Name</span>
                                            <div class="input-group">
                                                <input type="text"
                                                       name="last_name"
                                                       value="{{ old('last_name') ? old('last_name') : $profile->last_name }}"
                                                       maxlength='64'
                                                       class="form-control @error('last_name') is-invalid @enderror"
                                                       placeholder="Last Name">
                                                <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="icon-user"></i>
                                                </span>
                                                </div>
                                                @error('last_name')
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
                                            <span>Email Address</span>
                                            <div class="input-group">
                                                <input type="text"
                                                       name="email"
                                                       value="{{ old('email') ? old('email') : $profile->email }}"
                                                       maxlength='200'
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       placeholder="Email Address">
                                                <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="icon-email3"></i>
                                                </span>
                                                </div>
                                                @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <span>Phone Number</span>
                                            <div class="input-group">
                                                <input type="text"
                                                       name="phone"
                                                       value="{{ old('phone') ? old('phone') : $profile->phone }}"
                                                       maxlength='32'
                                                       class="form-control @error('phone') is-invalid @enderror"
                                                       placeholder="Phone Number">
                                                <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="icon-phone"></i>
                                                </span>
                                                </div>
                                                @error('phone')
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
                                            <span>Business Name</span>
                                            <div class="input-group">
                                                <input type="text"
                                                       name="company"
                                                       value="{{ old('company') ? old('company') : $profile->company }}"
                                                       maxlength='64'
                                                       class="form-control @error('company') is-invalid @enderror"
                                                       placeholder="Business Name">
                                                <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="icon-building"></i>
                                                </span>
                                                </div>
                                                @error('company')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <span>Address Line 1</span>
                                            <div class="input-group">
                                                <input
                                                    autocomplete="off"
                                                    role="presentation"
                                                       id="location"
                                                       type="text"
                                                       name="address"
                                                       value="{{ old('address') ? old('address') : $profile->address }}"
                                                       maxlength='64'
                                                       class="form-control @error('address') is-invalid @enderror"
                                                       placeholder="Address Line 1">
                                                <input class="lat" type="hidden" name="lat" value="{{ old('lat') ? old('lat') : $profile->lat }}">
                                                <input class="lng" type="hidden" name="lng" value="{{ old('lng') ? old('lng') : $profile->lng }}">
                                                <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="icon-address-card"></i>
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

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <span>Address Line 2</span>
                                            <div class="input-group">
                                                <input type="text"
                                                       name="address2"
                                                       value="{{ old('address2') ? old('address2') : $profile->address2}}"
                                                       maxlength='64'
                                                       class="form-control @error('address2') is-invalid @enderror"
                                                       placeholder="Address Line 2">
                                                <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="icon-address-card1"></i>
                                                </span>
                                                </div>
                                                @error('address2')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <span>City</span>
                                            <div class="input-group">
                                                <input type="text"
                                                       name="city"
                                                       value="{{ old('city') ? old('city') : $profile->city }}"
                                                       maxlength='64'
                                                       class="form-control @error('city') is-invalid @enderror"
                                                       placeholder="City">
                                                <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="icon-city"></i>
                                                </span>
                                                </div>
                                                @error('city')
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
                                            <span>State</span>
                                            <div class="input-group">
                                                <select id="state" name="state"
                                                        class="form-control @error('state') 'is-invalid' @enderror">
                                                    <option value=''>- Select a Business State -</option>
                                                    @foreach (\App\Helpers::getStates() as $state)
                                                        <option value="{{ $state['iso'] }}"
                                                                @if ($profile['state'] == $state['iso']) selected @endif>{{ $state['iso'] . ' - ' . $state['name'] }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="icon-stripe1"></i>
                                                </span>
                                                </div>

                                                @error('state')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <span>Zip Code</span>
                                            <div class="input-group">
                                                <input type="text"
                                                       name="zip"
                                                       value="{{ old('zip') ? old('zip') : $profile->zip }}"
                                                       maxlength='64'
                                                       class="form-control @error('zip') is-invalid @enderror"
                                                       placeholder="Zip Code">
                                                <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="icon-asterisk"></i>
                                                </span>
                                                </div>
                                                @error('zip')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

{{--                                <h4>Social Media</h4>--}}
{{--                                <p>If you have social media accounts for your business, enter them here.</p>--}}
{{--                                <div class='row'>--}}
{{--                                    <div class="col-4 form-group">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <span>Facebook</span>--}}
{{--                                            <div class="input-group">--}}
{{--                                                <input type="text"--}}
{{--                                                       name="social_facebook"--}}
{{--                                                       value="{{ old('social_facebook') ? old('social_facebook') : $profile->social_facebook }}"--}}
{{--                                                       maxlength='128'--}}
{{--                                                       class="form-control @error('social_facebook') is-invalid @enderror"--}}
{{--                                                       placeholder="Facebook URL">--}}
{{--                                                <div class="input-group-append">--}}
{{--                                                <span class="input-group-text">--}}
{{--                                                    <i class="icon-asterisk"></i>--}}
{{--                                                </span>--}}
{{--                                                </div>--}}
{{--                                                @error('social_facebook')--}}
{{--                                                <div class="invalid-feedback">--}}
{{--                                                    {{ $message }}--}}
{{--                                                </div>--}}
{{--                                                @enderror--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-4 form-group">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <span>Twitter</span>--}}
{{--                                            <div class="input-group">--}}
{{--                                                <input type="text"--}}
{{--                                                       name="social_twitter"--}}
{{--                                                       value="{{ old('social_twitter') ? old('social_twitter') : $profile->social_twitter }}"--}}
{{--                                                       maxlength='128'--}}
{{--                                                       class="form-control @error('social_twitter') is-invalid @enderror"--}}
{{--                                                       placeholder="Twitter URL">--}}
{{--                                                <div class="input-group-append">--}}
{{--                                                <span class="input-group-text">--}}
{{--                                                    <i class="icon-asterisk"></i>--}}
{{--                                                </span>--}}
{{--                                                </div>--}}
{{--                                                @error('social_twitter')--}}
{{--                                                <div class="invalid-feedback">--}}
{{--                                                    {{ $message }}--}}
{{--                                                </div>--}}
{{--                                                @enderror--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-4 form-group">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <span>Instagram</span>--}}
{{--                                            <div class="input-group">--}}
{{--                                                <input type="text"--}}
{{--                                                       name="social_instagram"--}}
{{--                                                       value="{{ old('social_instagram') ? old('social_instagram') : $profile->social_instagram }}"--}}
{{--                                                       maxlength='128'--}}
{{--                                                       class="form-control @error('social_instagram') is-invalid @enderror"--}}
{{--                                                       placeholder="Instagram URL">--}}
{{--                                                <div class="input-group-append">--}}
{{--                                                <span class="input-group-text">--}}
{{--                                                    <i class="icon-asterisk"></i>--}}
{{--                                                </span>--}}
{{--                                                </div>--}}
{{--                                                @error('social_instagram')--}}
{{--                                                <div class="invalid-feedback">--}}
{{--                                                    {{ $message }}--}}
{{--                                                </div>--}}
{{--                                                @enderror--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <br/>--}}
{{--                                <hr/>--}}
{{--                                <br/>--}}

                                <div class="form-group text-center">
                                    <button type="submit" class="button button-3d">
                                        <i class="icon-check"></i> Update Profile
                                    </button>

                                    <a href='{{ route('dashboard') }}' class="button button-3d button-dark">
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
