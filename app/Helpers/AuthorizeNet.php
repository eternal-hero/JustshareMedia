<?php

namespace App\Helpers;
;

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use \App\Models\User;

class AuthorizeNet
{
    public AnetAPI\MerchantAuthenticationType $merchantAuthentication;
    public string $endPoint;

    public function __construct() {
        /* Create a merchantAuthenticationType object with authentication details
           retrieved from the constants file */
        $this->merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $this->merchantAuthentication->setName(config('services.authorize.name'));
        $this->merchantAuthentication->setTransactionKey(config('services.authorize.key'));

        if(config('services.authorize.mode') == 'PRODUCTION') {
            $this->endPoint = \net\authorize\api\constants\ANetEnvironment::PRODUCTION;
        } else {
            $this->endPoint = \net\authorize\api\constants\ANetEnvironment::SANDBOX;
        }
    }

    /**
    * @deprecated
    */
    public function createCustomerProfile(User $user, $params)
    {

        // Set the transaction's refId
        $refId = 'ref' . time();

        // Create a Customer Profile Request
        //  1. (Optionally) create a Payment Profile
        //  2. (Optionally) create a Shipping Profile
        //  3. Create a Customer Profile (or specify an existing profile)
        //  4. Submit a CreateCustomerProfile Request
        //  5. Validate Profile ID returned

        // Set credit card information for payment profile
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($params['cardnumber']);
        $creditCard->setExpirationDate($params['expDate']);
        $creditCard->setCardCode($params['cvv']);
        $paymentCreditCard = new AnetAPI\PaymentType();
        $paymentCreditCard->setCreditCard($creditCard);

        // Create the Bill To info for new payment type
        $billTo = new AnetAPI\CustomerAddressType();
        $billTo->setFirstName($user->first_name);
        $billTo->setLastName($user->last_name);
        $billTo->setEmail($user->email);
        $billTo->setCompany($user->company);
        $billTo->setAddress($user->address);
        $billTo->setCity($user->city);
        $billTo->setState($user->state);
        $billTo->setZip($user->zip);
        $billTo->setCountry("USA");
        $billTo->setPhoneNumber($user->phone);

        // Create an array of any shipping addresses
        $shippingProfiles[] = $billTo;

        // Create a new CustomerPaymentProfile object
        $paymentProfile = new AnetAPI\CustomerPaymentProfileType();
        $paymentProfile->setCustomerType('individual');
        $paymentProfile->setBillTo($billTo);
        $paymentProfile->setPayment($paymentCreditCard);
        $paymentProfiles[] = $paymentProfile;

        // Create a new CustomerProfileType and add the payment profile object
        $customerProfile = new AnetAPI\CustomerProfileType();
        $customerProfile->setDescription("Customer #" . time() . ' ' . $user->first_name . ' ' . $user->last_name);
        $customerProfile->setMerchantCustomerId("M_" . time());
        $customerProfile->setEmail($user->email);
        $customerProfile->setpaymentProfiles($paymentProfiles);
        $customerProfile->setShipToList($shippingProfiles);

        // Assemble the complete transaction request
        $request = new AnetAPI\CreateCustomerProfileRequest();
        $request->setMerchantAuthentication($this->merchantAuthentication);
        $request->setRefId($refId);
        $request->setProfile($customerProfile);

        // Create the controller and get the response
        $controller = new AnetController\CreateCustomerProfileController($request);
        $response = $controller->executeWithApiResponse($this->endPoint);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
            $result['status'] = true;
            $result['customerProfileId'] = $response->getCustomerProfileId();
            $result['customerAddressId'] = $response->getCustomerShippingAddressIdList()[0];
            $result['customerPaymentProfileId'] = $response->getCustomerPaymentProfileIdList()[0];
        } else {
            $result['status'] = false;
            $errorMessages = $response->getMessages()->getMessage();
            $result['error_code'] = $errorMessages[0]->getCode();
            $result['message'] = $errorMessages[0]->getText();
        }
        return $result;
    }

    /**
     * @deprecated
     * */
    public function createSubscriptionFromCustomerProfile($customerParams, $params)
    {

        // Set the transaction's refId
        $refId = 'ref' . time();

        // Subscription Type Info
        $subscription = new AnetAPI\ARBSubscriptionType();
        $subscription->setName($params['subscriptionName']);

        $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
        $interval->setLength($params['intervalInMonths']);
        $interval->setUnit("months");

        $paymentSchedule = new AnetAPI\PaymentScheduleType();
        $paymentSchedule->setInterval($interval);
        $paymentSchedule->setStartDate(new \DateTime($params['startDate']));
        $paymentSchedule->setTotalOccurrences($params['TotalOccurrences']);

        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber($params['invoiceNumber']);
        $order->setDescription("Subscription : " . $params['subscriptionName']);
        $subscription->setOrder($order);

        $subscription->setPaymentSchedule($paymentSchedule);
        $subscription->setAmount($params['amount']);

        $profile = new AnetAPI\CustomerProfileIdType();
        $profile->setCustomerProfileId($customerParams['customerProfileId']);
        $profile->setCustomerPaymentProfileId($customerParams['customerPaymentProfileId']);
        $profile->setCustomerAddressId($customerParams['customerAddressId']);

        $subscription->setProfile($profile);

        $request = new AnetAPI\ARBCreateSubscriptionRequest();
        $request->setmerchantAuthentication($this->merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscription($subscription);
        $controller = new AnetController\ARBCreateSubscriptionController($request);

        $response = $controller->executeWithApiResponse($this->endPoint);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
            $result['status'] = true;
            $result['subscriptionId'] = $response->getSubscriptionId();

        } else {
            $result['status'] = false;
            $errorMessages = $response->getMessages()->getMessage();
            $result['error_code'] = $errorMessages[0]->getCode();
            $result['message'] = $errorMessages[0]->getText();
        }

        return $result;
    }

    /**
    * @deprecated
     */
    public function chargeCustomerProfile($profileid, $paymentprofileid, $amount)
    {
        // Set the transaction's refId
        $refId = 'ref' . time();

        $profileToCharge = new AnetAPI\CustomerProfilePaymentType();
        $profileToCharge->setCustomerProfileId($profileid);
        $paymentProfile = new AnetAPI\PaymentProfileType();
        $paymentProfile->setPaymentProfileId($paymentprofileid);
        $profileToCharge->setPaymentProfile($paymentProfile);

        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType( "authCaptureTransaction");
        $transactionRequestType->setAmount($amount);
        $transactionRequestType->setProfile($profileToCharge);

        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($this->merchantAuthentication);
        $request->setRefId( $refId);
        $request->setTransactionRequest( $transactionRequestType);
        $controller = new AnetController\CreateTransactionController($request);

        $response = $controller->executeWithApiResponse( $this->endPoint );

        if ($response != null)
        {
            if($response->getMessages()->getResultCode() == "Ok")
            {
                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getMessages() != null)
                {
                    $result ['status'] = true;
                    $result ['authorize_transaction_id'] = $tresponse->getTransId();
                    $result ['authorize_auth_code'] = $tresponse->getAuthCode();
                    $result ['authorize_transaction_code'] = $tresponse->getMessages()[0]->getCode();
                    $result ['authorize_transaction_description'] = $tresponse->getMessages()[0]->getDescription();
                }
                else
                {
                    //echo "Transaction Failed \n";
                    if($tresponse->getErrors() != null)
                    {
                        $result ['status'] = false;
                        $result ['error_code'] = $tresponse->getErrors()[0]->getErrorCode();
                        $result ['message'] = $tresponse->getErrors()[0]->getErrorText();
                    }
                }
            }
            else
            {
                //echo "Transaction Failed \n";
                $tresponse = $response->getTransactionResponse();
                if($tresponse != null && $tresponse->getErrors() != null)
                {
                    $result ['status'] = false;
                    $result ['error_code'] = $tresponse->getErrors()[0]->getErrorCode();
                    $result ['message'] = $tresponse->getErrors()[0]->getErrorText();
                }
                else
                {
                    $result ['status'] = false;
                    $result ['error_code'] = $response->getMessages()->getMessage()[0]->getCode();
                    $result ['message'] = $response->getMessages()->getMessage()[0]->getText();
                }
            }
        }
        else
        {
            $result ['status'] = false;
            $result ['error_code'] = 0;
            $result ['message'] = "No response returned";
        }
        return $result;
    }


    /**
     * @deprecated
     * */
    public function cancelSubscription($subscriptionId)
    {

        // Set the transaction's refId
        $refId = 'ref' . time();

        $request = new AnetAPI\ARBCancelSubscriptionRequest();
        $request->setMerchantAuthentication($this->merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscriptionId($subscriptionId);

        $controller = new AnetController\ARBCancelSubscriptionController($request);

        $response = $controller->executeWithApiResponse( $this->endPoint);

        $result = [];

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok"))
        {
            $result['status'] = 'success';
            $successMessages = $response->getMessages()->getMessage();
            $result['message'] = "SUCCESS : " . $successMessages[0]->getCode() . "  " .$successMessages[0]->getText();
        }
        else
        {
            $result['status'] = 'error';
            $errorMessages = $response->getMessages()->getMessage();
            $result['message'] =  "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText();
        }

        return $result;
    }

    /**
    * @deprecated
     */
    public function chargeCreditCard(User $user, float $amount, array $params)
    {

        // Set the transaction's refId
        $refId = 'ref' . time();

        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($params['cardnumber']);
        $creditCard->setExpirationDate($params['expDate']);
        $creditCard->setCardCode($params['cvv']);

        // Add the payment data to a paymentType object
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        // Create order information
        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber($params['invoiceNumber']);
        $order->setDescription($params['description']);

        // Set the customer's Bill To address
        $customerAddress = new AnetAPI\CustomerAddressType();
        $customerAddress->setFirstName($user->first_name);
        $customerAddress->setLastName($user->last_name);
        $customerAddress->setCompany($user->company);
        $customerAddress->setAddress($user->address);
        $customerAddress->setCity($user->city);
        $customerAddress->setState($user->state);
        $customerAddress->setZip($user->zip);
        $customerAddress->setCountry("USA");

        // Set the customer's identifying information
        $customerData = new AnetAPI\CustomerDataType();
        $customerData->setType("individual");
        $customerData->setId($user->authorize_customer_id);
        $customerData->setEmail($user->email);

        // Add values for transaction settings
        $duplicateWindowSetting = new AnetAPI\SettingType();
        $duplicateWindowSetting->setSettingName("duplicateWindow");
        $duplicateWindowSetting->setSettingValue("60");

        // Create a TransactionRequestType object and add the previous objects to it
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($amount);
        $transactionRequestType->setOrder($order);
        $transactionRequestType->setPayment($paymentOne);
        $transactionRequestType->setBillTo($customerAddress);
        $transactionRequestType->setCustomer($customerData);
        $transactionRequestType->addToTransactionSettings($duplicateWindowSetting);

        // Assemble the complete transaction request
        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($this->merchantAuthentication);
        $request->setRefId($refId);
        $request->setTransactionRequest($transactionRequestType);

        // Create the controller and get the response
        $controller = new AnetController\CreateTransactionController($request);
        $response = $controller->executeWithApiResponse($this->endPoint);

        if ($response != null) {
            // Check to see if the API request was successfully received and acted upon
            if ($response->getMessages()->getResultCode() == "Ok") {
                // Since the API request was successful, look for a transaction response
                // and parse it to display the results of authorizing the card
                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getMessages() != null) {
                    $result ['status'] = true;
                    $result ['authorize_transaction_id'] = $tresponse->getTransId();
                    $result ['authorize_auth_code'] = $tresponse->getAuthCode();
                    $result ['authorize_transaction_code'] = $tresponse->getMessages()[0]->getCode();
                    $result ['authorize_transaction_description'] = $tresponse->getMessages()[0]->getDescription();

                } else {
                    $result ['status'] = false;
                    if ($tresponse->getErrors() != null) {
                        $result ['error_code'] = $tresponse->getErrors()[0]->getErrorCode();
                        $result ['message'] = $tresponse->getErrors()[0]->getErrorText();
                    }
                }
                // Or, print errors if the API request wasn't successful
            } else {
                $result ['status'] = false;
                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getErrors() != null) {
                    $result ['error_code'] = $tresponse->getErrors()[0]->getErrorCode();
                    $result ['message'] = $tresponse->getErrors()[0]->getErrorText();

                } else {
                    $result ['error_code'] = $response->getMessages()->getMessage()[0]->getCode();
                    $result ['message'] = $response->getMessages()->getMessage()[0]->getText();
                }
            }
        } else {
            $result ['status'] = false;
            $result ['error_code'] = 0;
            $result ['message'] = "No response returned";
        }
        return $result;

    }

}
