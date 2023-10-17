<table>
    <tbody>
    @foreach($partnerCompanies as $partnerCompany)
        <tr>
            <td>{{ $partnerCompany->name }}</td>
            @foreach($partnerCompany->subscriptions as $subscription)
                <td>{{ $subscription->user->company }} {!! !$subscription->pivot->is_percentage ? '$' : '' !!}{{ $subscription->pivot->commission }}{!! $subscription->pivot->is_percentage ? '%' : '' !!}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
