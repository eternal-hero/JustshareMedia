@extends('template.layout')

@section('title', 'Account Management | Just Share Roofing Media')

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
                    <a href='{{ route('admin.accounts.add') }}' class='btn btn-primary'>Add</a>
                </span>

                <div class="heading-block border-0">
                    <h3>Accounts</h3>
                    <span>Customer List</span>
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
                                        <th>Email</th>
                                        <th>Name</th>
                                        <th>Company</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>CustomerID</th>
                                        <th>Registered On</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Email</th>
                                        <th>Name</th>
                                        <th>Company</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>CustomerID</th>
                                        <th>Registered On</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($accounts as $account)
                                        <tr>
                                            <td><a href='/admin/accounts/{{ $account->id}}'>{{ $account->email }}</a></td>
                                            <td><a href='/admin/accounts/{{ $account->id}}'>{{ $account->first_name }} {{ $account->last_name }}</a></td>
                                            <td><a href='/admin/accounts/{{ $account->id}}'>{{ $account->company }}</a></td>
                                            <td><a href='/admin/accounts/{{ $account->id}}'>{{ $account->is_admin == 1 ? 'Admin' : 'Customer' }}</a></td>
                                            <td>
                                                @if ($account->isEnabled())
                                                    <a href='{{ route('admin.accounts.view', ['id' => $account->id]) }}' style="color:green;font-weight:bold;">Enabled</a>
                                                @else
                                                    <a href='{{ route('admin.accounts.view', ['id' => $account->id]) }}' style="color:red;font-weight:bold;">Disabled</a>
                                                @endif
                                            </td>
                                            <td>{{ $account->authorize_customer_id }}</td>
                                            <td><a href='/admin/accounts/{{ $account->id}}'>{{ $account->created_at }}</a></td>
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
