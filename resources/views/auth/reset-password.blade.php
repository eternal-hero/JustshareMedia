@extends('template.layout')

@section('title', 'Login | Just Share Roofing Media')

@section('description', 'Login and manage your media account.')

@section('content')

<div class="content-wrap">
    <div class="container clearfix">

        <div class="tabs mx-auto mb-0 clearfix" id="tab-login-register" style="max-width: 500px;">

            {{-- <ul class="tab-nav tab-nav2 center clearfix">
                <li class="inline-block"><a href="#tab-login">Login</a></li>
                <li class="inline-block"><a href="#tab-register">Register</a></li>
            </ul> --}}

            <div class="tab-container">

                <div class="tab-content" id="tab-login">
                    <div class="card mb-0">
                        <div class="card-body" style="padding: 40px;">

                            @if (! $errors->isEmpty())
                                <div class="alert alert-danger">
                                    <i class="icon-exclamation-circle"></i><strong>Password update failed!</strong><br/>
                                    @foreach ($errors->all() as $error)
                                        @if ($error == 'This password reset token is invalid.')
                                            This password reset token is invalid. <a href='/recovery'>Click here to request a new password.</a><br/>
                                        @else
                                            {{ $error }}<br/>
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                            <form id="password-reset-form" name="password-reset-form" class="mb-0" action="/reset-password" method="post">

                                <h3>Update your Password</h3>

                                <p>Your password reset token has been confirmed. Enter your new password below.

                                <div class="row">

                                    <div class="col-12 form-group">
                                        <label for="login-form-email">Email Address:</label>
                                        <input type="text"
                                            id="login-form-email"
                                            name="email"
                                            value="{{ $email }}" 
                                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                                            placeholder=""
                                            readonly />

                                        @if ($errors->has('email'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('email') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-12 form-group">
                                        <label for="password-reset-form-password">Password:</label>
                                        <input type="password"
                                            id="password-reset-form-password"
                                            name="password"
                                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                                            value="" />
                                        @if ($errors->has('password'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('password') }}
                                            </div>
                                        @endif
                                    </div>

                                    <input type='hidden' name='token' value='{{ $token }}' />

                                    <div class="col-12 form-group">
                                        <button class="button button-3d button-black btn-block m-0" id="password-reset-form-submit" name="password-reset-form-submit" value="login">Set New Password</button>
                                    </div>

                                    @csrf
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection