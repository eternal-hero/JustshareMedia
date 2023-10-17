<table>
    <tbody>
    @foreach($salesReps as $salesRep)
        <tr>
            <td>{{ $salesRep->name }}</td>
            @foreach($salesRep->subscriptions as $subscription)
            <td>{{ $subscription->user->company }} {!! !$subscription->pivot->is_percentage ? '$' : '' !!}{{ $subscription->pivot->commission }}{!! $subscription->pivot->is_percentage ? '%' : '' !!}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
