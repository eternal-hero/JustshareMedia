<?php

namespace App\Listeners;

use App\Events\ChargeCustomerRequestFailedEvent;
use App\Mail\CanceledSubsNotifMail;
use App\Mail\FailedTransactionClientNotifMail;
use App\Mail\FailedTransactionNotifMail;
use App\Models\TransactionAttempt;
use App\Models\User;
use App\Repositories\PaymentRepository;
use Illuminate\Support\Facades\Mail;

class ChargeCustomerRequestFailedListener
{
    public PaymentRepository $paymentRepository;

    /**
     * Create the event listener.
     *
     * @param PaymentRepository $paymentRepository
     */
    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * Handle the event.
     *
     * @param ChargeCustomerRequestFailedEvent $event
     * @return void
     */
    public function handle(ChargeCustomerRequestFailedEvent $event)
    {
        $responseObject = $event->response->getResponseObject();
        $data = [
            'authorize_response_obj' => $responseObject,
            'messages' => $responseObject->getMessages(),
            'errors' => $responseObject->getTransactionResponse()->getErrors() ? $responseObject->getTransactionResponse()->getErrors() : null
        ];
        $this->paymentRepository->updateTransactionAttemptToFailed($event->reference, $data);
        // send email to admins
        $attempt = TransactionAttempt::where('reference', $event->reference)->first();
        $user = User::find($attempt->user_id);
        $reason =$responseObject->getTransactionResponse()->getErrors() ? $responseObject->getTransactionResponse()->getErrors()[0]->getErrorText() : 'The transaction was unsuccessful, reason not available.';
        $admins = User::where('is_admin', 1)->get();
        foreach ($admins as $admin) {
            Mail::to($admin)->send(new FailedTransactionNotifMail($user, $reason));
        }
        if($user->first_payment) {
            Mail::to($user)->send(new FailedTransactionClientNotifMail($user, $reason));
        }
    }
}
