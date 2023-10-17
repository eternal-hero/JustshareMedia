@extends('template.layout')

{{--@section('title', 'Login | Just Share Roofing Media')--}}
@section('title', 'Login | Just Share Media')

@section('description', 'Login and manage your media account.')

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
                                    <i class="icon-exclamation-circle"></i><strong>Login Failed!</strong> Please try again.
                                </div>
                            @endif

                            @if (session('loggedOut'))
                                <div class="alert alert-info">
                                    <i class="icon-exclamation-circle"></i><strong>Logout success!</strong> Your session has been cleared.
                                </div>
                            @endif

                            @if (session('status') && session('status') == 'Your password has been reset!')
                                <div class="alert alert-success">
                                    <i class="icon-exclamation-circle"></i><strong>Password updated!</strong> You may now log in with your new password.
                                </div>
                            @endif

                            <form id="login-form" name="login-form" class="mb-0" action="/login" method="post">

                                <h3>Login to your Account</h3>

                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label for="login-form-email">Email Address:</label>
                                        <input type="text"
                                            id="login-form-email"
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
                                        <label for="login-form-password">Password:</label>
                                        <input type="password"
                                            id="login-form-password"
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

                                    <div class="col-12 form-group">
                                        <button class="button button-3d button-black btn-block m-0" id="login-form-submit" name="login-form-submit" value="login">Login</button>
                                        <a href="{{route('password.request')}}" class="float-right">Forgot Password?</a>
                                    </div>

                                    @csrf
                                </div>

                            </form>

                            <div class='row text-center'>
                                <div class='col'>
                                    <br/>
                                    <p>Don't have an account? <a style="color: #4b81e4" href="{{route('signup')}}">Sign up today!</a></p>
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
