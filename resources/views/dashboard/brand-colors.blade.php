@extends('template.layout')

@section('title', 'Brand Colors | ' . config('app.name'))

@section('description', 'Update your account password')

@section('content')

    <div class="content-wrap">
        <div class="container clearfix">

            <div class="row clearfix">

                <div class="col-md-9">

                    {{-- <img src="images/icons/avatar.jpg" class="alignleft img-circle img-thumbnail my-0" alt="Avatar" style="max-width: 84px;"> --}}

                    <div class="heading-block border-0">
                        <h3>{{ $user->name }}</h3>
                        <span>Brand Colors</span>
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

                    <div class="row clearfix">
                        <div class="col-lg-12">
                            <p>Use this form to set Brand Colors.</p>

                            <p>
                            <form class="js-validation-signin" method="POST"
                                  action="{{ route('dashboard.brand-colors.update', $user) }}">
                                @csrf

                                @for ($i=0; $i <= 5; $i++)

                                    <div class="form-group">
                                        <div class="row">
                                            <input type="hidden" name="colors[{{ $i }}][key]" class="form-control"
                                                   value="{{ 'color_' . $i  }}"
                                                   placeholder="Color Name">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <input type="text" name="colors[{{ $i }}][value]"
                                                           class="form-control"
                                                           value="{{ $user->colors[$i]['value'] ?? '' }}"
                                                           placeholder="Color Code">
                                                    <span class="input-group-append">
                                                        <span class="input-group-text colorpicker-input-addon"><i></i></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                                <div class="form-group text-center">
                                    <button type="submit" class="button button-3d">
                                        <i class="icon-check"></i> Update Colors
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

@section('js_additional')
    <script src="/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.input-group').colorpicker();
        });
    </script>
@endsection

