<?php


namespace App\Helpers;


use App\Models\Subscription;
use Carbon\Carbon;

class MarkSubscriptionAsCanceled
{
    public function __invoke() {

        $now = Carbon::now();
        $subscriptionForCancellation = Subscription::whereDate('should_cancel_at', '<=', $now)->where('status', '!=', 'canceled')->get();
        foreach ($subscriptionForCancellation as $subscription) {
            $subscription->status = 'canceled';
            $subscription->save();
        }
    }
}
