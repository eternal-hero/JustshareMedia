@extends('template.layout')

@section('title', 'Update Coupon | Just Share Roofing Media')

@section('description', 'Updating a coupon')

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
        terms = ['monthly', 'yearly', 'contract'];

        // On ready
        $(document).ready(function() {
            // Show hidden value fields for enabled terms
            terms.forEach(function(term) {
                if(document.getElementById('term_' + term).checked) {
                    $('#value_' + term).css('display', 'inline');
                }
            });

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

        // Toggle value fields for term checkboxes
        function toggleValueInput(term) {
            // var input = document.getElementById('term_' + term);
            if (document.getElementById('term_' + term).checked) {
                $('#value_' + term).css('display', 'inline');
            } else {
                $('#value_' + term).css('display', 'none');
                $('#value_' + term).val('');
            }
        }
    </script>
@endsection

@section('content')

    <div class="content-wrap">
        <div class="container clearfix">

            <div class="row clearfix">

                <div class="col-md-9">

                    <div class="heading-block border-0">
                        <h3><a href='/admin/coupons/'>Additional Videos Coupons</a> > Add</h3>
                        <span>Adding a New Additional Videos Coupon</span>
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

                            <form class="js-validation-signin" method="POST" action="{{ route('admin.coupons.patch.additional', ['id' => $coupon->id]) }}">
                                @csrf
                                @method('patch')
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <h3>Code</h3>
                                            <div class="input-group">
                                                <input type="text"
                                                       name="code"
                                                       value="{{ $coupon->code }}"
                                                       maxlength='32'
                                                       class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}"
                                                       placeholder="Discount code (alpha-numeric, no spaces)"
                                                >
                                                @if ($errors->has('code'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('code') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <h3>Value</h3>
                                            <div class="input-group">
                                                <input type="text"
                                                       name="value"
                                                       value="{{ $coupon->value }}"
                                                       maxlength='32'
                                                       class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}"
                                                       placeholder="155.23"
                                                >
                                                @if ($errors->has('value'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('value') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <br/><hr/><br/>

                                <div class="form-group text-center">
                                    <button type="submit" class="button button-3d">
                                        <i class="icon-check"></i> Update Coupon
                                    </button>

                                    &nbsp;

                                    <a href='{{ route('admin.coupons') }}' class="button button-3d button-dark">
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
