@extends('template.layout')

@section('title', 'Coupon Management | Just Share Roofing Media')

@section('description', 'Managing order coupons')

@section('js_additional')
    <script src="/assets/js/components/bs-datatable.js"></script>
    <script>
		$(document).ready(function() {
			$('#datatable1').dataTable( {
                "order": [[ 0, "asc" ]]
            });
        });
	</script>
@endsection

@section('content')

<div class="content-wrap">
    <div class="container clearfix">

        <div class="row clearfix">

            <div class="col-md-9">

                <span style='float:right'>
                    <a href='{{ route('admin.coupons.add') }}' class='btn btn-primary'>Add</a>
                </span>

                <div class="heading-block border-0">
                    <h3>Coupons</h3>
                    <span>Discount Codes</span>
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

                        <div>
                            <table id="datatable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Code</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($coupons as $coupon)
                                        <tr>
                                            <td><a href='/admin/coupons/{{ $coupon->id}}'>{{ $coupon->code }}</a></td>
                                            <td><a href='/admin/coupons/{{ $coupon->id}}'>{{ $coupon->type }}</a></td>
                                            <td>
                                                @if ($coupon->isEnabled())
                                                    <a href='{{ route('admin.coupons.view', ['id' => $coupon->id]) }}' style="color:green;font-weight:bold;">Enabled</a>
                                                @else
                                                    <a href='{{ route('admin.coupons.view', ['id' => $coupon->id]) }}' style="color:red;font-weight:bold;">Disabled</a>
                                                @endif
                                            </td>
                                            <td><a href='/admin/coupons/{{ $coupon->id}}'>{{ $coupon->created_at }}</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

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