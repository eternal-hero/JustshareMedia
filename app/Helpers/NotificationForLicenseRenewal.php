<?php


namespace App\Helpers;


use App\Jobs\SendLicenseRenewalMailJob;
use App\Mail\LicenseRenewalMail;
use App\Models\Subscription;
use App\Models\User;
use App\Services\Licensing\LicenseDates;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationForLicenseRenewal
{

    public function __invoke() {
        $users = User::all();
        $now = Carbon::now();
        foreach ($users as $user) {
            if($user->isSubscribed()) {
                $subscription = Subscription::where('user_id', $user->id)->where('status', 'active')->first();
                $createdAt = new \DateTime($subscription->created_at);
                $monthsAfterFirstSubscription = $now->diffInMonths($createdAt->format('Y-m-d'));
                $availableLicenseDate = $subscription->created_at->copy()->addMonths($monthsAfterFirstSubscription);
                if($now->isSameDay($availableLicenseDate)) {
                    SendLicenseRenewalMailJob::dispatch($user);
                }
            }

        }
    }

}
