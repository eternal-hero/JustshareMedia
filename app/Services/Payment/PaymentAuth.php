<?php


namespace App\Services\Payment;


use net\authorize\api\contract\v1\MerchantAuthenticationType;

/**
 * Class PaymentAuth
 * @package App\Services\Payment
 */
class PaymentAuth
{
    /**
     * @var MerchantAuthenticationType
     */
    private MerchantAuthenticationType $merchantAuthenticationType;
    /**
     * @var string
     */
    private string $endPoint;

    /**
     * PaymentAuth constructor.
     * @param MerchantAuthenticationType $merchantAuthenticationType
     */
    public function __construct(MerchantAuthenticationType $merchantAuthenticationType) {
        $this->merchantAuthenticationType = $merchantAuthenticationType;
        $this->merchantAuthenticationType->setName(config('services.authorize.name'));
        $this->merchantAuthenticationType->setTransactionKey(config('services.authorize.key'));
        if(config('services.authorize.mode') == 'PRODUCTION') {
            $this->endPoint = \net\authorize\api\constants\ANetEnvironment::PRODUCTION;
        } else {
            $this->endPoint = \net\authorize\api\constants\ANetEnvironment::SANDBOX;
        }
    }

    /**
     * @return MerchantAuthenticationType
     */
    public function getMerchantAuthenticationType(): MerchantAuthenticationType
    {
        return $this->merchantAuthenticationType;
    }

    /**
     * @return string
     */
    public function getEndPoint(): string
    {
        return $this->endPoint;
    }

}
