@extends('template.layout')

@section('title', 'Subscription Management | Just Share Roofing Media')

@section('description', 'Managing Subscriptions')

@section('js_additional')
    <script src="/assets/js/components/bs-datatable.js"></script>
    <script>
		$(document).ready(function() {
			$('#datatable1').dataTable( {
                "order": [[ 6, "desc" ]]
            });
        });

		$('.lead').change(function() {
            $.ajaxSetup({
                headers:
                    { 'X-CSRF-TOKEN': '{{ @csrf_token() }}' }
            });

            $.ajax({
                url: '{{ route('subscriptions.leads')}}',
                type: 'POST',
                data: {
                    lead: $(this).val(),
                    subscription: $(this).attr('id')
                },
            })
        })
	</script>
@endsection

@section('content')

<div class="content-wrap">
    <div class="container clearfix">
        <div class="row clearfix">
            <div class="col-md-9">
                <div class="heading-block border-0">
                    <h3>Subscriptions</h3>
                    <span>Subscriptions for all users</span>
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
{{--                                        <th>ID</th>--}}
                                        <th>Status</th>
                                        <th>User</th>
{{--                                        <th>Company</th>--}}
                                        <th>Sales Rep</th>
                                        <th>Partner Company</th>
                                        <th>Plan</th>
{{--                                        <th>Term</th>--}}
                                        <th>Amount</th>
                                        <th>Received</th>
                                        <th>Lead</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
{{--                                        <th>ID</th>--}}
                                        <th>Status</th>
                                        <th>User</th>
{{--                                        <th>Company</th>--}}
                                        <th>Sales Rep</th>
                                        <th>Partner Company</th>
                                        <th>Plan</th>
{{--                                        <th>Term</th>--}}
                                        <th>Amount</th>
                                        <th>Received</th>
                                        <th>Lead</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($subscriptions as $subscription)
                                        <tr>
{{--                                            <td>#{{ $subscription->id }}</td>--}}
                                            <td>
                                                {{ $subscription->status }}
                                                @if($subscription->status == 'canceled')
                                                    <br>
                                                    Reason: {{ $subscription->cancelReason ? $subscription->cancelReason->name : '' }}
                                                @endif
                                                <br>
                                                <a href="{{ route('subscriptions.status-states', ['subscription' => $subscription->id]) }}">Status History</a>
                                                <br>
                                                @if($subscription->status != 'canceled' && !$subscription->should_cancel_at)
                                                <a href="{{ route('admin-cancel-subscription', ['subscription' => $subscription->id]) }}">Cancel Subscription</a>
                                                @endif
                                                @if($subscription->should_cancel_at)
                                                    Will be canceled on: {{ $subscription->should_cancel_at }}
                                                @endif
                                            </td>
                                            <td>
                                                <a target="_blank" href="{{ route('admin.accounts.view', ['id' => $subscription->user->id]) }}">
                                                    {{ $subscription->user->first_name }} {{ $subscription->user->last_name }}
                                                    <br>
                                                    {{ $subscription->user->company }}
                                                </a>
                                            </td>
                                            <td>
                                                @foreach($subscription->salesReps as $salesRep)
                                                    {{ $salesRep->name }} : {!! $salesRep->pivot->is_percentage ? '' : '$' !!}{{ $salesRep->pivot->commission }}{!! $salesRep->pivot->is_percentage ? '%' : '' !!}
                                                    <br>
                                                @endforeach
                                                <a href="{{ route('admin.sales-rep-manage', ['subscription' => $subscription->id]) }}">Manage</a>
                                            </td>
                                            <td>
                                                @foreach($subscription->partnerCompanies as $partnerCompany)
                                                    {{ $partnerCompany->name }} : {!! $partnerCompany->pivot->is_percentage ? '' : '$' !!}{{ $partnerCompany->pivot->commission }}{!! $partnerCompany->pivot->is_percentage ? '%' : '' !!}
                                                    <br>
                                                @endforeach
                                                <a href="{{ route('admin.partner-company-manage', ['subscription' => $subscription->id]) }}">Manage</a>
                                            </td>
                                            <td>{{ $subscription->plan->name }} <br> {{ $subscription->term }}</td>
                                            <td>{!! \App\Services\Subscription\SubscriptionCalculations::getPriceHtml($subscription) !!}</td>
                                            <td>{{ $subscription->created_at }}</td>
                                            <td>
                                                <select name="" id="sub_{{ $subscription->id }}" class="lead">
                                                    <option value="0">---</option>
                                                    @foreach($leads as $lead)
                                                        <option {{ $lead->id == $subscription->lead_id ? 'selected' : '' }} value="{{ $lead->id }}">{{ $lead->name }}</option>
                                                    @endforeach


{{--                                                    <option {!! $subscription->lead == 'Facebook' ? 'selected' : '' !!} value="Facebook">Facebook</option>--}}
{{--                                                    <option {!! $subscription->lead == 'Partnership' ? 'selected' : '' !!} value="Partnership">Partnership</option>--}}
{{--                                                    <option {!! $subscription->lead == 'Company Event' ? 'selected' : '' !!} value="Company Event">Company Event</option>--}}
                                                </select>
                                            </td>
                                            <td>
                                                <a href="{{ route('upcoming-transactions.change-price', ['subscription' => $subscription->id]) }}">Change Price</a>
                                            </td>
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
