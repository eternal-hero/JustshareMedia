<?php

namespace App\Events;

use App\Contracts\Payment\RequestAttemptResponses\ChargeCustomerProfileAttemptResponse;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class ChargeCustomerRequestSuccessEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ChargeCustomerProfileAttemptResponse $response;

    /**
     * Create a new event instance.
     *
     * @param ChargeCustomerProfileAttemptResponse $response
     */
    public function __construct(ChargeCustomerProfileAttemptResponse $response)
    {
        $this->response = $response;
    }
}
