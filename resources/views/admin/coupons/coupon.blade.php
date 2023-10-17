@extends('template.layout')

@section('title', 'Coupon: ' . $coupon->code . ' | Just Share Roofing Media')

@section('description', 'Managing a single coupon')

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
                    <h3><a href='/admin/coupons/'>Coupons</a> > {{ $coupon->code }}</h3>
                    @if ($coupon->isEnabled())
                        <span style='color:green;font-weight:bold;'>ENABLED</span>
                    @else
                        <span style='color:red;font-weight:bold;'>DISABLED</span>
                    @endif
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

                        <form class="js-validation-signin" method="POST" action="{{ route('admin.coupons.patch', ['id' => $coupon->id]) }}">
                            @csrf
                            @method('patch')

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <h3>Code</h3>
                                        <p>The string coupon / discount code the customer must enter.</p>
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
                                        <h3>Type</h3>
                                        <p>A <b>fixed</b> coupon will apply a fixed dollar discount. A <b>percentage</b> coupon will apply
                                            a percentage based discount</p>
                                        <div class="input-group">
                                            <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name='type'>
                                                <option value=''>---</option>
                                                @php
                                                    $options = ['fixed', 'percentage'];
                                                    foreach ($options as $option) {
                                                        $html = "<option value='$option' ";
                                                        if ($option == $coupon->type) $html .= "selected";
                                                        $html .= ">" . ucwords($option) . "</option>";
                                                        echo $html;
                                                    }
                                                @endphp
                                            </select>
                                            @if ($errors->has('type'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('type') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <h3>Plans</h3>
                                        <p>Select the plans eligible for this coupon</p>
                                        @if (session('error_plan'))
                                            <div style='font-weight:bold;color:red;'>
                                                {{ session('error_plan') }}
                                            </div>
                                            <br/>
                                        @endif
                                        @foreach ($plans as $plan)
                                            <div class="input-group">
                                                <b>{{ $plan->name }}</b>
                                                <input type='checkbox'
                                                    name='plan_{{ $plan->id }}'
                                                    class="form-control {{ $errors->has("plan_$plan->id") ? 'is-invalid' : '' }}"
                                                    @foreach ($coupon->getPlans() as $couponPlan)
                                                        @if ($plan->id == $couponPlan->id)
                                                            checked
                                                        @endif
                                                    @endforeach
                                                >
                                            </div>
                                            <br/>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <h3>Terms & Value</h3>
                                        <p>Select the terms you would like discounts applied for, then set a value for each term.</p>
                                        @if (session('error_term'))
                                            <div style='font-weight:bold;color:red;'>
                                                {{ session('error_term') }}
                                            </div>
                                            <br/>
                                        @endif
                                        @foreach ($terms as $term)
                                            <div class="input-group">
                                                <b>{{ ucwords($term) }}</b>
                                                <input type='checkbox'
                                                    id='term_{{ $term }}'
                                                    name='term_{{ $term }}'
                                                    onchange="toggleValueInput('{{ $term }}')"
                                                    class="form-control {{ $errors->has("term_$term") ? 'is-invalid' : '' }}"
                                                    @foreach ($coupon->getTerms() as $couponTerm)
                                                        @if ($term == $couponTerm)
                                                            checked
                                                        @endif
                                                    @endforeach
                                                >

                                                <input type="number"
                                                    id="value_{{ $term }}"
                                                    name="value_{{ $term }}"
                                                    style="display:none;";
                                                    @php
                                                        switch($term) {
                                                            case 'monthly':
                                                                echo "value='" . $coupon->getValues()[0] . "'";
                                                                break;
                                                            case 'yearly':
                                                                echo "value='" . $coupon->getValues()[1] . "'";
                                                                break;
                                                            case 'contract':
                                                                echo "value='" . $coupon->getValues()[2] . "'";
                                                                break;
                                                        }
                                                    @endphp
                                                    maxlength='32'
                                                    class="form-control {{ $errors->has(old("value_$term")) ? 'is-invalid' : '' }}"
                                                    placeholder="Value for {{ $term }} term">
                                            </div>
                                            <br/>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <h3>Promotion Dates (optional)</h3>
                                        <p>If dates are entered, the coupon can only be used following those dates. If no
                                            dates are entered, the coupon will be valid as long as it is enabled.</p>

                                        <label>Start Date to End Date</label>
                                        <div class="input-daterange component-datepicker input-group">
                                            <input type="text"
                                                name="start_at"
                                                @php
                                                    if ($coupon->start_at) {
                                                        echo 'value="' . $coupon->start_at->format('m/d/Y') . '"';
                                                    }
                                                @endphp
                                                class="form-control text-left"
                                                placeholder="MM/DD/YYYY"
                                            >
                                            @if ($errors->has('start_at'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('start_at') }}
                                                </div>
                                            @endif

                                            <div class="input-group-prepend"><div class="input-group-text">to</div></div>

                                            <input type="text"
                                                name="end_at"
                                                @php
                                                    if ($coupon->end_at) {
                                                        echo 'value="' . $coupon->end_at->format('m/d/Y') . '"';
                                                    }
                                                @endphp
                                                class="form-control text-left"
                                                placeholder="MM/DD/YYYY"
                                            >
                                            @if ($errors->has('end_at'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('end_at') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br/>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <h3>Status</h3>
                                        <p>If the coupon is not enabled, it cannot be used regardless of start or end dates.</p>
                                        <div class="input-group">
                                            <b>Enabled</b>
                                            <input type='checkbox'
                                                name='enabled'
                                                class="form-control {{ $errors->has('enabled') ? 'is-invalid' : '' }}"
                                                @if ($coupon->isEnabled())
                                                    checked
                                                @endif
                                            >
                                            @if ($errors->has('enabled'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('enabled') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <h3>Recurring</h3>
                                        <p>Indicates if the coupon is a recurring discount. If not enabled, the coupon is a one time discount.</p>
                                        <div class="input-group">
                                            <b>Recurring</b>
                                            <input type='checkbox'
                                                name='recurring'
                                                class="form-control {{ $errors->has('recurring') ? 'is-invalid' : '' }}"
                                                @if ($coupon->isRecurring())
                                                    checked
                                                @endif
                                            >
                                            @if ($errors->has('recurring'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('recurring') }}
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
