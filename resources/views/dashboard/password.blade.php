@extends('template.layout')

@section('title', 'My Password | ' . config('app.name'))

@section('description', 'Update your account password')

@section('content')

<div class="content-wrap">
    <div class="container clearfix">

        <div class="row clearfix">

            <div class="col-md-9">

                {{-- <img src="images/icons/avatar.jpg" class="alignleft img-circle img-thumbnail my-0" alt="Avatar" style="max-width: 84px;"> --}}

                <div class="heading-block border-0">
                    <h3>{{ Auth::user()->name }}</h3>
                    <span>My Password</span>
                </div>

                <div class="clear"></div>

                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="icon-exclamation-circle"></i>{{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        <i class="icon-exclamation-circle"></i>{{ session('error') }}
                    </div>
                @endif

                @if (! $errors->isEmpty())
                    <div class="alert alert-danger">
                        <i class="icon-exclamation-circle"></i><strong>Sorry!</strong> An error occurred with your request. Please check your fields and try again.
                    </div>
                @endif

                <div class="row clearfix">

                    <div class="col-lg-12">

                        <p>Use this form to update your password.</p>

                        <p>
                            <form class="js-validation-signin" method="POST" action="{{ route('dashboard.password') }}">
                                @csrf

                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="password" name="current_password" maxlength='64' class="form-control {{ $errors->has('current_password') ? 'is-invalid' : '' }}" placeholder="Current Password">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="icon-key"></i>
                                            </span>
                                        </div>
                                        @if ($errors->has('current_password'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('current_password') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="password" name="new_password" maxlength='64' class="form-control {{ $errors->has('new_password') ? 'is-invalid' : '' }}" placeholder="New Password">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="icon-asterisk"></i>
                                            </span>
                                        </div>
                                        @if ($errors->has('new_password'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('new_password') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="password" name="confirm_password" maxlength='64' class="form-control {{ $errors->has('confirm_password') ? 'is-invalid' : '' }}" placeholder="Confirm Password">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="icon-asterisk"></i>
                                            </span>
                                        </div>
                                        @if ($errors->has('confirm_password'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('confirm_password') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group text-center">
                                    <button type="submit" class="button button-3d">
                                        <i class="icon-check"></i> Update Password
                                    </button>

                                    &nbsp;

                                    <a href='{{ route('dashboard') }}' class="button button-3d button-dark">
                                        <i class="icon-arrow-left"></i> Go Back
                                    </a>
                                </div>
                            </form>
                        </p>

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
