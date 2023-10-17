@extends('template.layout')

@section('title', 'Tax Rates Management | ' . config('app.name'))

@section('description', 'Managing accounts')

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
                    <a href='{{ route('tax-rate.create') }}' class='btn btn-primary'>Add</a>
                </span>

                <div class="heading-block border-0">
                    <h3>Tax Rates</h3>
                    <span>Tax Rates List</span>
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
                                        <th>State Name</th>
                                        <th>State Iso Code</th>
                                        <th>Tax Rate (%)</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>State Name</th>
                                        <th>State Iso Code</th>
                                        <th>Tax Rate (%)</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($taxRates as $rate)
                                        <tr>
                                            <td><a href='{{route('tax-rate.edit', $rate)}}'>{{ $rate->state_name }}</a></td>
                                            <td><a href='{{route('tax-rate.edit', $rate)}}'>{{ $rate->state_iso_code }}</a></td>
                                            <td><a href='{{route('tax-rate.edit', $rate)}}'>{{ $rate->tax_rate }}</a></td>
                                            <td><a class="button button-3d button-mini button-rounded button-red" href='{{route('tax-rate.show', $rate )}}'>Delete</a></td>
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
