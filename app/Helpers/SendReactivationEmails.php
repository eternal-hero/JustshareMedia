<?php


namespace App\Helpers;


use App\Jobs\ReactivationEmailJob;
use App\Models\Subscription;
use Carbon\Carbon;

class SendReactivationEmails
{
    public function __invoke()
    {
        $canceledSubscriptions = Subscription::where('status', 'canceled')->where('reactivation_email_count', '<', 12)->get();
        $now = Carbon::now();
        foreach ($canceledSubscriptions as $subscription) {
            $lastEmailSentAt = $subscription->should_cancel_at->copy()->addMonths($subscription->reactivation_email_count);
            // send every 2 months
            if ($now->diffInMonths($lastEmailSentAt) >= 2) {
                $subscription->reactivation_email_count = $subscription->reactivation_email_count + 2;
                $subscription->save();
                ReactivationEmailJob::dispatch($subscription->user, $subscription->reactivate_email_cancel_code);
            }
        }
    }
}
