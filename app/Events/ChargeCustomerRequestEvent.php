<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use net\authorize\api\contract\v1\TransactionRequestType;

class ChargeCustomerRequestEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $user;
    public float $amount;
    public TransactionRequestType $transactionRequestType;
    public string $reference;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param float $amount
     * @param TransactionRequestType $transactionRequestType
     */
    public function __construct(User $user, float $amount, TransactionRequestType $transactionRequestType, string $reference)
    {
        $this->user = $user;
        $this->amount = $amount;
        $this->transactionRequestType = $transactionRequestType;
        $this->reference = $reference;
    }

}
