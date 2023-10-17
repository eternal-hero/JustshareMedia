@extends('template.layout')

@section('title', 'Subscription Status States | Just Share Roofing Media')

@section('description', 'Subscription Status States')

@section('js_additional')
    <script src="/assets/js/components/bs-datatable.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable1').dataTable( {
                "order": [[ 0, "desc" ]]
            });
        });
    </script>
@endsection

@section('content')

    <div class="content-wrap">
        <div class="container clearfix">

            <div class="row clearfix">

                <div class="col-md-9">

                    <div class="heading-block border-0">
                        <h3>Canceled Subscriptions</h3>
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
                                        <th>Date</th>
                                        <th>User</th>
                                        <th>Reason</th>
                                        <th>Comment</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Date</th>
                                        <th>User</th>
                                        <th>Reason</th>
                                        <th>Comment</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach ($canceledSubscriptions as $subscription)
                                        <tr>
                                            <td>

                                                @if($subscription->status === 'canceled')
                                                    Canceled at:
                                                @else
                                                    Will be canceled at:
                                                @endif
                                                {{ $subscription->should_cancel_at ? $subscription->should_cancel_at->format('Y-m-d') : ''}}</td>
                                            <td>{{ $subscription->user->email }}</td>
                                            <td>{{ $subscription->cancelReason ? $subscription->cancelReason->name : '' }}</td>
                                            <td>{{ $subscription->cancel_comment ? $subscription->cancel_comment : '' }}</td>
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
