@extends('template.layout')

@section('title', 'Add Account | Just Share Roofing Media')

@section('description', 'Adding a new account')

@section('css_additional')
    <!-- Date & Time Picker CSS -->
    <link rel="stylesheet" href="/assets/css/components/datepicker.css" type="text/css" />
    <link rel="stylesheet" href="/assets/css/components/timepicker.css" type="text/css" />
    <link rel="stylesheet" href="/assets/css/components/daterangepicker.css" type="text/css" />
@endsection

@section('js_additional')
    <!-- Date & Time Picker JS -->
    <script src="/assets/js/components/moment.js"></script>
    <script src="/assets/js/components/timepicker.js"></script>
    <script src="/assets/js/components/datepicker.js"></script>
    <!-- Include Date Range Picker -->
	<script src="/assets/js/components/daterangepicker.js"></script>

    <!-- Inline JS -->
    <script>
        // Variables
        terms = ['monthly', 'yearly'];

        // On ready
        $(document).ready(function() {
            // Date time picker stuff
            $('.component-datepicker.default').datepicker({
				autoclose: true,
				startDate: "today",
			});
			$('.component-datepicker.today').datepicker({
				autoclose: true,
				startDate: "today",
				todayHighlight: true
			});
			$('.component-datepicker.past-enabled').datepicker({
				autoclose: true,
			});
			$('.component-datepicker.format').datepicker({
				autoclose: true,
				format: "dd-mm-yyyy",
			});
			$('.component-datepicker.autoclose').datepicker();
			$('.component-datepicker.disabled-week').datepicker({
				autoclose: true,
				daysOfWeekDisabled: "0"
			});
			$('.component-datepicker.highlighted-week').datepicker({
				autoclose: true,
				daysOfWeekHighlighted: "0"
			});
			$('.component-datepicker.mnth').datepicker({
				autoclose: true,
				minViewMode: 1,
				format: "mm/yy"
			});
			$('.component-datepicker.multidate').datepicker({
				multidate: true,
				multidateSeparator: " , "
			});
			$('.component-datepicker.input-daterange').datepicker({
				autoclose: true
			});
			$('.component-datepicker.inline-calendar').datepicker();
        });
    </script>
@endsection

@section('content')

<div class="content-wrap">
    <div class="container clearfix">

        <div class="row clearfix">

            <div class="col-md-9">

                <div class="heading-block border-0">
                    <h3><a href='/admin/accounts/'>Accounts</a> > Add</h3>
                    <span>Adding a New Account</span>
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

                        <form class="js-validation-signin" method="POST" action="{{ route('admin.accounts.post') }}">
                            @csrf

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <h5>Email</h5>
                                        <div class="input-group">
                                            <input type="text"
                                                name="email"
                                                value="{{ old('email') }}"
                                                maxlength='125'
                                                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                placeholder="User's email and communication address"
                                            >
                                            @if ($errors->has('email'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('email') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <h5>Password</h5>
                                        <div class="input-group">
                                            <input type="password"
                                                name="password"
                                                value="{{ old('password') }}"
                                                maxlength='64'
                                                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                                placeholder="This password will be used to login"
                                            >
                                            @if ($errors->has('password'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('password') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <h5>Confirm Password</h5>
                                        <div class="input-group">
                                            <input type="password"
                                                name="password_confirmation"
                                                value="{{ old('password_confirmation') }}"
                                                maxlength='64'
                                                class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                                placeholder="Confirm the new user's password"
                                            >
                                            @if ($errors->has('password_confirmation'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('password_confirmation') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <h5>First Name</h5>
                                        <div class="input-group">
                                            <input type="text"
                                                name="first_name"
                                                value="{{ old('first_name') }}"
                                                maxlength='32'
                                                class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                                                placeholder="First name of the account contact"
                                            >
                                            @if ($errors->has('first_name'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('first_name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <h5>Last Name</h5>
                                        <div class="input-group">
                                            <input type="text"
                                                name="last_name"
                                                value="{{ old('last_name') }}"
                                                maxlength='32'
                                                class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                                                placeholder="Last name of the account contact"
                                            >
                                            @if ($errors->has('last_name'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('last_name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <h5>Company</h5>
                                        <div class="input-group">
                                            <input type="text"
                                                name="company"
                                                value="{{ old('company') }}"
                                                maxlength='50'
                                                class="form-control {{ $errors->has('company') ? 'is-invalid' : '' }}"
                                                placeholder="Name of the company this user is associated with"
                                            >
                                            @if ($errors->has('company'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('company') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <h5>Phone Number</h5>
                                        <div class="input-group">
                                            <input type="text"
                                                name="phone"
                                                value="{{ old('phone') }}"
                                                maxlength='11'
                                                class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                                placeholder="Business contact phone number"
                                            >
                                            @if ($errors->has('phone'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('phone') }}
                                                </div>
                                            @endif
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
                                                value="{{ old('address') }}"
                                                maxlength='32'
                                                class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                                placeholder="Primary address line"
                                            >
                                            @if ($errors->has('address'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('address') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <h5>Address 2</h5>
                                        <div class="input-group">
                                            <input type="text"
                                                name="address2"
                                                value="{{ old('address2') }}"
                                                maxlength='32'
                                                class="form-control {{ $errors->has('address2') ? 'is-invalid' : '' }}"
                                                placeholder="Secondary address line (building number, suite number, etc)"
                                            >
                                            @if ($errors->has('address2'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('address2') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <h5>City</h5>
                                        <div class="input-group">
                                            <input type="text"
                                                name="city"
                                                value="{{ old('city') }}"
                                                maxlength='32'
                                                class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}"
                                                placeholder="City of the business location."
                                            >
                                            @if ($errors->has('city'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('city') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <h5>State</h5>
                                        <select id="state" name="state" class="sm-form-control {{ $errors->has('state') ? 'is-invalid' : '' }}">
                                            <option value=''>- Select a Business State -</option>
                                            @foreach (\App\Helpers::getStates() as $state)
                                                @if (old('state') == $state['iso'])
                                                    <option value="{{ $state['iso'] }}" selected>{{ $state['name'] }}</option>
                                                @else
                                                    <option value="{{ $state['iso'] }}">{{ $state['name'] }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('state'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('state') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <h5>Zip</h5>
                                        <div class="input-group">
                                            <input type="text"
                                                name="zip"
                                                value="{{ old('zip') }}"
                                                maxlength='32'
                                                class="form-control {{ $errors->has('zip') ? 'is-invalid' : '' }}"
                                                placeholder="Business location zip code"
                                            >
                                            @if ($errors->has('zip'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('zip') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr/>

                            <div class="row">
                                <div class="col">
                                    <h2>Social Media (optional)</h2>
                                    <p>If available, enter the business social media URLs.</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <h5>Facebook</h5>
                                        <div class="input-group">
                                            <input type="text"
                                                name="social_facebook"
                                                value="{{ old('social_facebook') }}"
                                                maxlength='32'
                                                class="form-control {{ $errors->has('social_facebook') ? 'is-invalid' : '' }}"
                                                placeholder="Facebook URL"
                                            >
                                            @if ($errors->has('social_facebook'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('social_facebook') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <h5>Twitter</h5>
                                        <div class="input-group">
                                            <input type="text"
                                                name="social_twitter"
                                                value="{{ old('social_twitter') }}"
                                                maxlength='32'
                                                class="form-control {{ $errors->has('social_twitter') ? 'is-invalid' : '' }}"
                                                placeholder="Twitter URL"
                                            >
                                            @if ($errors->has('social_twitter'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('social_twitter') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <h5>Instagram</h5>
                                        <div class="input-group">
                                            <input type="text"
                                                name="social_instagram"
                                                value="{{ old('social_instagram') }}"
                                                maxlength='32'
                                                class="form-control {{ $errors->has('social_instagram') ? 'is-invalid' : '' }}"
                                                placeholder="Instagram URL"
                                            >
                                            @if ($errors->has('address2'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('social_instagram') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <h5>Type</h5>
                                        <p>A <b>fixed</b> coupon will apply a fixed dollar discount. A <b>percentage</b> coupon will apply 
                                            a percentage based discount</p>
                                        <div class="input-group">
                                            <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name='type'>
                                                <option value=''>---</option>
                                                @php
                                                    $options = ['fixed', 'percentage'];
                                                    foreach ($options as $option) {
                                                        $html = "<option value='$option' ";
                                                        if ($option == old('type')) $html .= "selected";
                                                        $html .= ">" . ucwords($option) . "</option>";
                                                        echo $html;
                                                    }
                                                @endphp
                                            </select>
                                            @if ($errors->has('type'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('type') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            {{-- <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <h5>Promotion Dates (optional)</h5>
                                        <p>If dates are entered, the coupon can only be used following those dates. If no 
                                            dates are entered, the coupon will be valid as long as it is enabled.</p>

                                        <label>Start Date to End Date</label>
                                        <div class="input-daterange component-datepicker input-group">
                                            <input type="text"
                                                name="start_at"
                                                value="{{ old('start_at') }}"
                                                class="form-control text-left"
                                                placeholder="MM/DD/YYYY"
                                            >
                                            @if ($errors->has('start_at'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('start_at') }}
                                                </div>
                                            @endif

                                            <div class="input-group-prepend"><div class="input-group-text">to</div></div>

                                            <input type="text"
                                                name="end_at"
                                                value="{{ old('end_at') }}"
                                                class="form-control text-left"
                                                placeholder="MM/DD/YYYY"
                                            >
                                            @if ($errors->has('end_at'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('end_at') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br/> --}}

                            <hr/>

                            <h2>User Settings</h2>
                            <p>Various settings for users. Defaults are set for a normal customer account.</p>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <h5>Enabled</h5>
                                            
                                            <input type='checkbox'
                                                name='enabled'
                                                class="form-control {{ $errors->has('enabled') ? 'is-invalid' : '' }}"
                                                checked
                                            >
                                            <p>If a user's account is not enabled, they will not be able to login or place orders.</p>
                                            @if ($errors->has('enabled'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('enabled') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <h5>Onboarded</h5>
                                            
                                            <input type='checkbox'
                                                name='onboarded'
                                                class="form-control {{ $errors->has('onboarded') ? 'is-invalid' : '' }}"
                                                @if ( old('onboarded') == 'on')
                                                    checked                                                    
                                                @endif
                                            >
                                            <p>Sets the onboarded flag on the account, and causes the onboarding information to display.</p>
                                            @if ($errors->has('enabled'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('enabled') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <h5>Is Admin</h5>
                                            
                                            <input type='checkbox'
                                                name='is_admin'
                                                class="form-control {{ $errors->has('is_admin') ? 'is-invalid' : '' }}"
                                                @if ( old('is_admin') == 'on')
                                                    checked                                                    
                                                @endif
                                            >
                                            <p>Enables all administrative features within the dashboard and provides full system access.</p>
                                            @if ($errors->has('is_admin'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('is_admin') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br/><hr/><br/>
    
                            <div class="form-group text-center">
                                <button type="submit" class="button button-3d">
                                    <i class="icon-check"></i> Add User
                                </button>

                                &nbsp;
    
                                <a href='{{ route('admin.accounts') }}' class="button button-3d button-dark">
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