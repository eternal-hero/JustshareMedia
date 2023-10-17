<?php

namespace App\Events;

use App\Contracts\Payment\RequestAttemptResponses\ChargeCustomerProfileAttemptResponse;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChargeCustomerRequestFailedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ChargeCustomerProfileAttemptResponse $response;
    public string $reference;

    /**
     * Create a new event instance.
     *
     * @param ChargeCustomerProfileAttemptResponse $response
     * @param string $reference
     */
    public function __construct(ChargeCustomerProfileAttemptResponse $response, string $reference)
    {
        $this->response = $response;
        $this->reference = $reference;
    }
}
