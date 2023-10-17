<?php

namespace App\Providers;

use App\Events\CancelSubscriptionFailedEvent;
use App\Events\CancelSubscriptionSuccessEvent;
use App\Events\ChargeCustomerRequestEvent;
use App\Events\ChargeCustomerRequestFailedEvent;
use App\Events\ChargeCustomerRequestSuccessEvent;
use App\Events\CustomerPaymentProfileRequestEvent;
use App\Events\SubscribeUserRequestFailedEvent;
use App\Events\SubscribeUserRequestSuccessEvent;
use App\Listeners\CancelSubscriptionFailedListener;
use App\Listeners\CancelSubscriptionSuccessListener;
use App\Listeners\ChargeCustomerRequestFailedListener;
use App\Listeners\ChargeCustomerRequestListener;
use App\Listeners\ChargeCustomerRequestSuccessListener;
use App\Listeners\CustomerPaymentProfileRequestListener;
use App\Listeners\SubscribeUserRequestFailedListener;
use App\Listeners\SubscribeUserRequestSuccessListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ChargeCustomerRequestEvent::class => [
            ChargeCustomerRequestListener::class
        ],
        ChargeCustomerRequestSuccessEvent::class => [
            ChargeCustomerRequestSuccessListener::class
        ],
        ChargeCustomerRequestFailedEvent::class => [
            ChargeCustomerRequestFailedListener::class
        ],
        SubscribeUserRequestSuccessEvent::class => [
            SubscribeUserRequestSuccessListener::class
        ],
        SubscribeUserRequestFailedEvent::class => [
            SubscribeUserRequestFailedListener::class
        ],
        CancelSubscriptionSuccessEvent::class => [
            CancelSubscriptionSuccessListener::class
        ],
        CancelSubscriptionFailedEvent::class => [
            CancelSubscriptionFailedListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {

    }
}
