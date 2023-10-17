@extends('template.layout')

@section('title', 'Account Recovery | Just Share Roofing Media')

@section('description', 'Recovery access to your media account.')

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

                            @if (session('status') && session('status') == 'We have emailed your password reset link!')
                                <h3>Recover your Account</h3>
                                
                                <div class="alert alert-success">
                                    <i class="icon-exclamation-circle"></i><strong>Request received!</strong> You will receive an email with further instructions.
                                </div>
                            @endif

                            @if (session('status') != 'We have emailed your password reset link!')
                                <form id="recovery-form" name="recovery-form" class="mb-0" action="/recovery" method="post">

                                    <h3>Recover your Account</h3>

                                    <p>Enter your account's email address to receive password recovery instructions.</p>

                                    <div class="row">
                                        <div class="col-12 form-group">
                                            <label for="recovery-form-email">Email Address:</label>
                                            <input type="text"
                                                id="recovery-form-email"
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
                                            <button class="button button-3d button-black btn-block m-0" id="recovery-form-submit" name="recovery-form-submit" value="login">Recover</button>
                                        </div>

                                        @csrf
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection