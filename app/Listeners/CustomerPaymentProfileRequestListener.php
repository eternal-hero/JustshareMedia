<?php

namespace App\Listeners;

use App\Events\CustomerPaymentProfileRequestEvent;

class CustomerPaymentProfileRequestListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CustomerPaymentProfileRequestEvent  $event
     * @return void
     */
    public function handle(CustomerPaymentProfileRequestEvent $event)
    {
        // TODO store data before sending to Authorize.net
    }
}
