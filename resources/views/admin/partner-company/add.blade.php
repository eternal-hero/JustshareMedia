@extends('template.layout')

@section('title', 'Add Partner Company | Just Share Roofing Media')

@section('description', 'Adding Partner Company')

@section('content')

    <div class="content-wrap">
        <div class="container clearfix">

            <div class="row clearfix">

                <div class="col-md-9">

                    <div class="heading-block border-0">
                        <h3>Adding a Partner Company</h3>
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

                            <form class="js-validation-signin" method="POST" action="{{ route('admin.partner-company-store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <h3>Name</h3>
                                            <div class="input-group">
                                                <input type="text"
                                                       name="name"
                                                >
                                                @if ($errors->has('name'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('name') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group text-center">
                                    <button type="submit" class="button button-3d">
                                        <i class="icon-check"></i> Add Partner Company
                                    </button>
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
