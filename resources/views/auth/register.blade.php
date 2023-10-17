@extends('template.layout')

@section('title', 'Register | Just Share Roofing Media')

@section('description', 'Create your media management account.')

@section('js_additional')
    <!-- Google Recaptcha -->
    {!! NoCaptcha::renderJs() !!}
@endsection

@section('content')

<div class="content-wrap">
    <div class="container clearfix">

        <div class="tabs mx-auto mb-0 clearfix" id="tab-login-register" style="max-width: 500px;">

            <div class="tab-container">

                <div class="tab-content" id="tab-login">
                    <div class="card mb-0">
                        <div class="card-body" style="padding: 40px;">

                            @if (! $errors->isEmpty())
                                <div class="alert alert-danger">
                                    <p><i class="icon-exclamation-circle"></i><strong>Oops!</strong> There was a problem creating your account.</p>
                                    <p>@foreach ($errors->all() as $error)
                                        {{ $error }}<br/>
                                    @endforeach</p>
                                </div>
                            @endif

                            <form id="register-form" name="register-form" class="mb-0" action="/register" method="post">

                                <h3>Create Your Account</h3>

                                <p>Fill out these fields to create your account. You will be able to choose your plan after logging in.</p>

                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label for="register-form-email">Email Address:</label>
                                        <input type="text"
                                            id="register-form-email"
                                            name="email"
                                            value="{{ old('email') }}"
                                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                            placeholder="" />

                                        @if ($errors->has('email'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('email') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-12 form-group">
                                        <label for="register-form-password">Password:</label>
                                        <input type="password"
                                            id="register-form-password"
                                            name="password"
                                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                            value="" />
                                        @if ($errors->has('password'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('password') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-12 form-group text-center">
                                        <div style='display:inline-block;'>
                                            {!! NoCaptcha::display() !!}
                                        </div>

                                        @if ($errors->has('g-recaptcha-response'))
                                            <br/>
                                            <span class="help-block" style='color:red;'>
                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class='col'>
                                        <p>By creating an account, you agree to our <a href='/terms-conditions'>Terms and Conditions</a> and <a href='/privacy-policy'>Privacy Policy</a>.
                                    </div>

                                    <div class="col-12 form-group">
                                        <button class="button button-3d button-black btn-block m-0" id="register-form-submit" name="register-form-submit" value="register">Create My Account</button>
                                    </div>

                                    @csrf
                                </div>

                            </form>

                            <div class='row text-center'>
                                <div class='col'>
                                    <br/>
                                    <p>Already have an account? <a href='/login'>Click here to login!</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection
