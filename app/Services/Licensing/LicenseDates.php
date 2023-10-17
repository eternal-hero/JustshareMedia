<?php


namespace App\Services\Licensing;


use App\Models\LicensedVideo;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;

class LicenseDates implements \App\Contracts\Licensing\LicenseDates
{

    public function daysUntilNewLicenseIsAvailable(User $user): int
    {
        if($user->canEditVideo()) {
            return 0;
        }

        $subscription = Subscription::where('user_id', $user->id)->first();
        if($subscription->status === Subscription::STATUS_UNPAID) {
            return -99999;
        }

        $now = Carbon::now();
        $licenseAvailableDate = $this->licenseAvailableDate($user);
        if($licenseAvailableDate === false) {
            return -9999;
        }
        return $licenseAvailableDate->diffInDays($now);
    }

    public function renewalDate(User $user)
    {
        return $this->licenseAvailableDate($user);
    }

    protected function licenseAvailableDate(User $user) {
        $subscription = Subscription::where('user_id', $user->id)->where('status', 'active')->first();
        if(!$subscription) {
            return false;
        }
        $now = Carbon::now();
        $monthsBeforeRenewal = $subscription->end_at->copy()->diffInMonths($now);
        $renewalDate = $subscription->end_at->copy()->subMonths($monthsBeforeRenewal);

        return $renewalDate;
    }
}
