@extends('template.layout')

@section('title', 'Create Tax Rate | ' . config('app.name'))

@section('description', 'Managing accounts')

@section('content')

<div class="content-wrap">
    <div class="container clearfix">
        <div class="row clearfix">
            <div class="col-md-9">
                <div class="heading-block border-0">
                    <h3><a href='{{ route('tax-rate.index') }}'>Tax Rates</a> > Create a new Tax Rate</h3>
                    <span>Tax Rate</span>
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

                        <form class="js-validation-signin" method="POST" action="{{ route('tax-rate.store')}}">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <h5>State Name</h5>
                                        <div class="input-group">
                                            <input type="text"
                                                name="state_name"
                                                value="{{ old('state_name')}}"
                                                class="form-control @error('state_name') is-invalid @enderror"
                                            >
                                            @error ('state_name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <h5>State ISO Code</h5>
                                        <div class="input-group">
                                            <input type="text"
                                                   name="state_iso_code"
                                                   value="{{ old('state_iso_code') }}"
                                                   class="form-control @error('state_iso_code') is-invalid @enderror"
                                            >
                                            @error('state_iso_code')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <h5>Tax Rate (%)</h5>
                                        <div class="input-group">
                                            <input type="text"
                                                   name="tax_rate"
                                                   value="{{ old('tax_rate')}}"
                                                   class="form-control @error('tax_rate') is-invalid @enderror"
                                            >
                                            @error('tax_rate')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr/>

                            <div class="form-group text-center">
                                <button type="submit" class="button button-3d">
                                    <i class="icon-check"></i> Save Tax Rate
                                </button>
                                &nbsp;
                                <a href='{{ route('tax-rate.index') }}' class="button button-3d button-dark">
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
