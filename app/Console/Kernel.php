<?php

namespace App\Console;

use App\Helpers\ChargeSubscriptions;
use App\Helpers\MarkSubscriptionAsCanceled;
use App\Helpers\NotificationForLicenseRenewal;
use App\Helpers\SendReactivationEmails;
use App\Helpers\SubscribeUser;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
//        $schedule->call(SubscribeUser::class)->everyMinute();
        $schedule->call(ChargeSubscriptions::class)->daily();
//        $schedule->call(SubscribeUser::class)->everyMinute();
        $schedule->call(MarkSubscriptionAsCanceled::class)->everySixHours();
        $schedule->call(NotificationForLicenseRenewal::class)->daily();
        $schedule->call(SendReactivationEmails::class)->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
