{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

@extends('template.layout')

@section('title', 'Verify Your Account | Just Share Roofing Media')

@section('description', 'Verify your account for access to our website.')

@section('content')

<div class="content-wrap">
    <div class="container clearfix">

        <div class="tabs mx-auto mb-0 clearfix" style="max-width: 500px;">

            <div class="tab-container">

                <div class="tab-content" id="tab-login">
                    <div class="card mb-0">
                        <div class="card-body" style="padding: 40px;">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif
                            <h2>Verify Your Email</h2>
                            <p>Please check your email for a verification link. Email verification is required before you can access your Dashboard.</p>
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Click here to request another email') }}</button>.
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection