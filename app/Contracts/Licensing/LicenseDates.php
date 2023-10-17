<?php


namespace App\Contracts\Licensing;


use App\Models\User;
use Carbon\Carbon;

interface LicenseDates
{
    public function daysUntilNewLicenseIsAvailable(User $user): int;
    public function renewalDate(User $user);
}
