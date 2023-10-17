<?php


namespace App\Services\Payment;



use App\Contracts\Payment\CustomerProfileParams;
use App\Contracts\Payment\GatewayObjects\CustomerAddress;
use App\Contracts\Payment\RequestAttemptResponses\ARBCancelSubscriptionAttemptResponse;
use App\Contracts\Payment\RequestAttemptResponses\ChargeCustomerProfileAttemptResponse;
use App\Contracts\Payment\RequestAttemptResponses\CustomerProfileCreateAttemptResponse;
use App\Contracts\Payment\RequestAttemptResponses\CustomerProfileUpdateAttemptResponse;
use App\Contracts\Payment\RequestAttemptResponses\SubscribeUserAttemptResponse;
use App\Events\CancelSubscriptionFailedEvent;
use App\Events\CancelSubscriptionSuccessEvent;
use App\Events\ChargeCustomerRequestEvent;
use App\Events\ChargeCustomerRequestFailedEvent;
use App\Events\ChargeCustomerRequestSuccessEvent;
use App\Events\SubscribeUserRequestFailedEvent;
use App\Events\SubscribeUserRequestSuccessEvent;
use App\Models\PendingSubscription;
use App\Models\Subscription;
use App\Models\User;
use App\Services\Payment\GatewayObjects\CustomerExProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

/**
 * Class CustomerProfileService
 * @package App\Services\Payment
 */
class CustomerProfileService
    extends AbstractCustomerProfileService
    implements \App\Contracts\Payment\CustomerProfileService
{

    public function deleteProfile($profileId) {
        $response = $this->deleteCustomerProfileRequestHandler->execute($profileId);
    }

    public function updateAddress($user, $address) {
        $response = $this->updateCustomerAddressRequestHandler->execute($user,  $address);
    }



    /**
     * @param CustomerProfileParams $customerProfileParams
     * @return CustomerProfileCreateAttemptResponse
     */
    public function create(CustomerProfileParams $customerProfileParams): CustomerProfileCreateAttemptResponse {
        // Prepare data
        $user = $customerProfileParams->getUser();
        $reference = 'ref_customer_' . $user->id;
        $creditCardType = $this->createCreditCard($customerProfileParams);
        $paymentType = $this->createPayment($creditCardType);
        $customerAddressType = $this->createCustomerAddress($user);
        $customerPaymentProfileType = $this->createCustomerPaymentProfile($customerAddressType, $paymentType);
        $customerDescription = "Customer #" . $user->id . ' ' . $user->first_name . ' ' . $user->last_name;
        $merchantId = "M_" . $user->id;
        $customerProfileType = $this->createCustomerProfile($customerDescription, $merchantId, $user->email, $customerPaymentProfileType,  $customerAddressType);
        // Execute with request handler
        $response = $this->customerPaymentProfileRequestHandler->execute($reference, $customerProfileType);
        // Set Payment response to Attempt Response Obj
        $this->customerProfileCreateAttemptResponse->setResponse($response);
        // Return attempt response type
        return $this->customerProfileCreateAttemptResponse;
    }

    public function update(\App\Services\Payment\CustomerProfileParams $customerProfileParams, CustomerAddress $customerAddress) : CustomerProfileUpdateAttemptResponse {
        // docs
//        https://github.com/AuthorizeNet/sample-code-php/blob/master/CustomerProfiles/update-customer-payment-profile.php
        $user = $customerProfileParams->getUser();
        $reference = 'ref_customer_' . $user->id;
        $creditCardType = $this->createCreditCard($customerProfileParams);
        $paymentType = $this->createPayment($creditCardType);
        $customerAddressType = $this->createCustomerAddress($user);
        $customerPaymentProfileType = $this->createCustomerPaymentProfile($customerAddressType, $paymentType);
        $customerDescription = "Customer #" . $user->id . ' ' . $user->first_name . ' ' . $user->last_name;
        $merchantId = "M_" . $user->id;

        $customerExProfileType = $this->createCustomerExProfile($customerDescription, $merchantId, $user->authorize_customer_payment_profile_id, $paymentType, $customerAddress);
        // Execute with request handler
        $response = $this->updateCustomerProfileRequestHandler->execute($user->authorize_customer_id, $customerExProfileType);
        // Set Payment response to Attempt Response Obj
        $this->customerProfileUpdateAttemptResponse->setResponse($response);
        // Return attempt response type
        return $this->customerProfileUpdateAttemptResponse;
    }


    /**
     * @param User $user
     * @param float $amount
     * @param \App\Models\Order $order
     * @param string $description
     * @return ChargeCustomerProfileAttemptResponse
     */
    public function charge(User $user, float $amount, \App\Models\Order $order, string $description) : ChargeCustomerProfileAttemptResponse {
        // Prepare data
        $amount = number_format((float)$amount, 2, '.', '');
//        dd($amount);
        $reference = 'chrg_' . time();
        $paymentProfileType = $this->createPaymentProfile($user);
        $customerProfilePaymentType = $this->createCustomerProfilePayment($user);
        $customerProfilePaymentType->setPaymentProfile($paymentProfileType);
        $orderType = $this->createOrder($order->id, $description);
        $transactionRequestType = $this->createTransactionRequest($customerProfilePaymentType, $amount, $orderType);
        // Execute with request handler and dispatch event
        Event::dispatch(new ChargeCustomerRequestEvent($user, $amount, $transactionRequestType, $reference));
        $response = $this->createTransactionRequestHandler->execute($reference, $transactionRequestType);
        // Set Payment response to Attempt Response Obj
        $this->chargeCustomerProfileAttemptResponse->setResponse($response);
        // Dispatch attempt event type
        if($this->chargeCustomerProfileAttemptResponse->isSuccessful()) {
            Event::dispatch(new ChargeCustomerRequestSuccessEvent($this->chargeCustomerProfileAttemptResponse));
        } else {
            Event::dispatch(new ChargeCustomerRequestFailedEvent($this->chargeCustomerProfileAttemptResponse, $reference));
        }

        // Return attempt response type
        return $this->chargeCustomerProfileAttemptResponse;
    }

    public function chargeCard(CustomerProfileParams $customerProfileParams, \App\Models\Order $order, float $amount, string $description) : ChargeCustomerProfileAttemptResponse {
        $reference = 'chrg1_' . time();
        $user = $customerProfileParams->getUser();
        $creditCardType = $this->createCreditCard($customerProfileParams);
        $paymentType = $this->createPayment($creditCardType);
        $orderType = $this->createOrder($order->id, $description);
        $customerAddressType = $this->createCustomerAddress($customerProfileParams->getUser());
        $customerDataType = $this->createCustomerData($customerProfileParams->getUser());
        $settingType = $this->createSetting();
        $transactionRequestType = $this->createCCTransactionRequest($amount, $orderType, $paymentType, $customerAddressType, $customerDataType, $settingType);
        // Execute with request handler and dispatch event
        Event::dispatch(new ChargeCustomerRequestEvent($user, $amount, $transactionRequestType, $reference));
        $response = $this->createTransactionRequestHandler->execute($reference, $transactionRequestType);
        // Set Payment response to Attempt Response Obj
        $this->chargeCustomerProfileAttemptResponse->setResponse($response);
        // Dispatch attempt event type
        if($this->chargeCustomerProfileAttemptResponse->isSuccessful()) {
            Event::dispatch(new ChargeCustomerRequestSuccessEvent($this->chargeCustomerProfileAttemptResponse));
        } else {
            Event::dispatch(new ChargeCustomerRequestFailedEvent($this->chargeCustomerProfileAttemptResponse, $reference));
        }

        // Return attempt response type
        return $this->chargeCustomerProfileAttemptResponse;
    }

    /**
     * @param PendingSubscription $pendingSubscription
     * @return SubscribeUserAttemptResponse
     */
    public function subscribe(PendingSubscription $pendingSubscription) : SubscribeUserAttemptResponse {
        // Prepare data
        $userModel = $pendingSubscription->user;
        $orderModel = $pendingSubscription->order;
        $planModel = $pendingSubscription->plan;
        $reference = 'sub_' . $userModel->id . '_' . $pendingSubscription->id;
        $intervalAType = $this->createInterval($pendingSubscription->term == 'yearly' ? 12 : 1);
        $paymentScheduleType = $this->createPaymentSchedule($intervalAType, new \DateTime($pendingSubscription->start_at), 9999);
        $orderType = $this->createOrder($orderModel->id, $planModel->name);
        $customerProfileIdType = $this->createCustomerProfileId($userModel);
        $subscriptionType = $this->createSubscription(
            $planModel->name,
            $orderType,
            $paymentScheduleType,
            $pendingSubscription->amount,
            $customerProfileIdType
        );
        // Execute with request handler
        $response = $this->ARBCreateSubscriptionRequestHandler->execute($reference, $subscriptionType);
        // Set Payment response to Attempt Response Obj
        $this->subscribeUserAttemptResponse->setResponse($response);
        // Dispatch attempt event type
        if($this->subscribeUserAttemptResponse->isSuccessful()) {
            Event::dispatch(new SubscribeUserRequestSuccessEvent($pendingSubscription, $this->subscribeUserAttemptResponse));
        } else {
            Event::dispatch(new SubscribeUserRequestFailedEvent($pendingSubscription, $this->subscribeUserAttemptResponse));
        }
        // Return attempt response type
        return $this->subscribeUserAttemptResponse;
    }

    /**
     * @param Subscription $subscription
     * @return ARBCancelSubscriptionAttemptResponse
     */
    public function cancelSubscription(Subscription $subscription) : ARBCancelSubscriptionAttemptResponse {
        $response = $this->ARBCancelSubscriptionRequestHandler->execute('csub_' . $subscription->id, $subscription->authorize_subscription_id);
        $this->ARBCancelSubscriptionAttemptResponse->setResponse($response);
        if($this->ARBCancelSubscriptionAttemptResponse->isSuccessful()) {
            Event::dispatch(new CancelSubscriptionSuccessEvent($subscription));
        } else {
            Event::dispatch(new CancelSubscriptionFailedEvent($subscription));
        }

        return $this->ARBCancelSubscriptionAttemptResponse;
    }
}

