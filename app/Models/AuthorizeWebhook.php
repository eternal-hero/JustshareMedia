<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorizeWebhook extends Model
{
    use HasFactory;

    /**
     * @var object  SimpleXML object representing the Webhook notification
     */
    private $webhook;

    /**
     * @var string  JSON string that is the Webhook notification sent by Authorize.Net
     */
    private $webhookJson;

    /**
     * @var array  HTTP headers sent with the notification
     */
    private $headers;

    /**
     * @var string  Authorize.Net Signature Key
     */
    private $signature;

    /**
     * Creates the response object with the response json returned from the API call
     *
     * @param  string $signature Authorize.Net Signature Key
     * @param  string $payload   Webhook Notification sent by Authorize.Net
     * @param  array  $headers   HTTP headers sent with Webhook. Optional if PHP is run as an Apache module
     */
    public function __construct(string $signature, string $payload, array $headers = [])
    {

        $this->signature   = $signature;
        $this->webhookJson = $payload;
        $this->headers     = $headers;
        if (empty($this->headers)) {
            $this->headers = $this->getAllHeaders();
        }

        $this->headers = array_change_key_case($this->headers, CASE_UPPER);
    }

    /**
     * Validates a webhook signature to determine if the webhook is valid
     *
     * @return bool
     */
    public function isValid(): bool
    {
        $hashedBody = strtoupper(hash_hmac('sha512', $this->webhookJson, $this->signature));
        return (isset($this->headers['X-ANET-SIGNATURE']) &&
            strtoupper(explode('=', $this->headers['X-ANET-SIGNATURE'])[1]) === $hashedBody);
    }

    /**
     * Retrieves all HTTP headers of a given request
     *
     * @return array
     */
    protected function getAllHeaders(): array {

        if (function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
        } else {
            $headers = [];
            foreach ($_SERVER as $key => $value) {
                if (strpos($key, 'HTTP_') === 0) {
                    $headers[str_replace('_', '-', substr($key, 5))] = $value;
                }
            }
        }
        return $headers;
    }
}
