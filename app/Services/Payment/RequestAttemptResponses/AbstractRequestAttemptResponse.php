<?php


namespace App\Services\Payment\RequestAttemptResponses;


use Illuminate\Support\Facades\Log;

/**
 * Class AbstractRequestAttemptResponse
 * @package App\Services\Payment\RequestAttemptResponses
 */
abstract class AbstractRequestAttemptResponse
{
    /**
     * @var bool
     */
    protected bool $isSuccessful;

    /**
     * AbstractRequestAttemptResponse constructor.
     */
    public function __construct()
    {
        $this->isSuccessful = false;
    }

    /**
     * @return bool
     */
    final public function isSuccessful(): bool
    {
        return $this->isSuccessful;
    }

    /**
     * @param $response
     */
    final protected function handleResponse($response) {
//        dd($response);
        Log::info(json_encode($response));
        $log = new \Logger\Laravel\Models\Log();
        $this->response = $response;
        if(method_exists($this->response, 'getTransactionResponse')) {
            $logMessage['responseCode'] = $response->getTransactionResponse()->getResponseCode();
            $logMessage['authCode'] = $response->getTransactionResponse()->getAuthCode();
            $logMessage['avsResultCode'] = $response->getTransactionResponse()->getAvsResultCode();
            $logMessage['avsResultCode'] = $response->getTransactionResponse()->getAvsResultCode();
            $logMessage['ref_id'] = $response->getRefId();
            $log->message = 'Card/User charge';
            $log->context = $logMessage;
            $log->save();
            if($response->getTransactionResponse()->getResponseCode() == 1) {
                $this->isSuccessful = true;
            }
        } else {
            $message = $response->getMessages();
            if(strtoupper($message->getResultCode()) == 'OK') {
                $this->isSuccessful = true;
            }
        }
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->response->getMessages()->getMessage()[0]->getText();
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->response->getMessages()->getMessage()[0]->getCode();
    }
}
