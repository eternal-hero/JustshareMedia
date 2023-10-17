<?php


namespace App\Services\Payment\RequestHandlers;


use App\Contracts\Payment\RequestHandlers\UpdateCustomerAddressRequestHandler;
use App\Contracts\Payment\RequestHandlers\UpdateCustomerProfileRequestHandler;
use App\Services\Payment\PaymentAuth;
use net\authorize\api\contract\v1\CreditCardType;
use net\authorize\api\contract\v1\CustomerAddressType;
use net\authorize\api\contract\v1\CustomerPaymentProfileExType;
use net\authorize\api\contract\v1\CustomerProfileExType;
use net\authorize\api\contract\v1\GetCustomerPaymentProfileRequest;
use net\authorize\api\contract\v1\PaymentType;
use net\authorize\api\contract\v1\UpdateCustomerPaymentProfileRequest;
use net\authorize\api\contract\v1\UpdateCustomerProfileRequest;
use net\authorize\api\controller\GetCustomerPaymentProfileController;
use net\authorize\api\controller\UpdateCustomerPaymentProfileController;
use net\authorize\api\controller\UpdateCustomerProfileController;

class UpdateCustomerAddressRequest implements UpdateCustomerAddressRequestHandler
{

    protected $paymentAuth;
    protected $request;
    protected $customerProfileExType;

    public function __construct(PaymentAuth $paymentAuth, UpdateCustomerPaymentProfileRequest $request, CustomerPaymentProfileExType $customerProfileExType)
    {
        $this->paymentAuth = $paymentAuth;
        $this->request = $request;
        $this->customerProfileExType = $customerProfileExType;
    }

    public function execute($user, $address)
    {
//        dd($user->authorize_customer_id);
        $getRequest = new GetCustomerPaymentProfileRequest();
        $getRequest->setRefId('prof_u_'. time());
        $getRequest->setCustomerProfileId($user->authorize_customer_id);
        $getRequest->setCustomerPaymentProfileId($user->authorize_customer_payment_profile_id);

        $getRequest->setMerchantAuthentication($this->paymentAuth->getMerchantAuthenticationType());

        $getController = new GetCustomerPaymentProfileController($getRequest);

        $response = $getController->executeWithApiResponse($this->paymentAuth->getEndPoint());

        $billto = new CustomerAddressType();
        $billto = $response->getPaymentProfile()->getbillTo();
        $billto->setFirstName("Mrs Mary");
        $billto->setLastName("Doe");
        $billto->setAddress("9 New St.");
        $billto->setCity("Brand New City");
        $billto->setState("WA");
        $billto->setZip("98004");
        $billto->setPhoneNumber("000-000-0000");
        $billto->setfaxNumber("999-999-9999");
        $billto->setCountry("USA");

//        $paymentprofile->setBillTo($billto);

//
//        $this->customerProfileExType->setCustomerProfileId($user->authorize_customer_id);
//        $this->customerProfileExType->setCustomerProfileId($user->authorize_customer_id);

//        $this->request->set

//        $creditCard = new CreditCardType();
//        $creditCard->setCardNumber();
//        $creditCard->setExpirationDate("2038-12");

        $existingPaymentCard = $response->getPaymentProfile()->getPayment()->getCreditCard();

        $creditCard = new CreditCardType();
        $creditCard->setCardNumber( $existingPaymentCard->getCardNumber());
        $creditCard->setExpirationDate($existingPaymentCard->getExpirationDate());

//dd($creditCard);


        $paymentCreditCard = new PaymentType();
        $paymentCreditCard->setCreditCard($creditCard);


        $this->customerProfileExType->setCustomerPaymentProfileId($user->authorize_customer_payment_profile_id);
        $this->customerProfileExType->setPayment($paymentCreditCard);

        $this->customerProfileExType->setBillTo($billto);
        $this->customerProfileExType->setCustomerPaymentProfileId($user->authorize_customer_payment_profile_id);


        $this->request->setCustomerProfileId($user->authorize_customer_id);
        $this->request->setPaymentProfile( $this->customerProfileExType );

        $this->request->setMerchantAuthentication($this->paymentAuth->getMerchantAuthenticationType());
        $controller = new UpdateCustomerPaymentProfileController($this->request);

        $response = $controller->executeWithApiResponse($this->paymentAuth->getEndPoint());
//        dd($response);
    }
}
