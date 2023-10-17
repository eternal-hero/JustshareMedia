<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuthorizeWebhook;
use Illuminate\Support\Facades\Mail;

class WebhooksController extends Controller
{
    public function authorizeWebHook(Request $request)
    {
        $authorize_payment_signature_key = config('services.authorize.signature');

        // getallheaders() is php standard function.
        $headers = getallheaders();
        $payload = $request->getContent(); // for laravel
        //$payload = file_get_contents('php://input') // for non Laravel platforms
        // initialization of Model class
        $webhook = new AuthorizeWebhook($authorize_payment_signature_key, $payload, $headers);

        // check the valid signature and payload data.
        if ($webhook->isValid()) {

            // Access notification values
            $payload_json_obj = json_decode($payload);
            // Get the transaction ID
            $transactionId = $payload_json_obj->payload->id;

            // get authorized.net transaction details.
            //$response = $this->getTransactionDetails($transactionId);

            $this->AuthWebhookTestEmail($transactionId, 'Webhook Triggered. Transaction id found.');
            http_response_code(200);

        } else {
            $this->AuthWebhookTestEmail('Empty', 'Webhook Triggered. Transaction id is not found.');
            http_response_code(200);
        }
    }

    public function AuthWebhookTestEmail($transaction_id, $status){
        $email_data = array (
            'to' => 'a.lashin@wstlnk.com',
            'to_name' =>  'Artem Lashin',
            'subject' => 'auth webhook triggered email',
            'from_email' => config('mail.mailers.smtp.from'),
            'from_name' => config('mail.mailers.smtp.name'),
        );

        $email_data['email_content'] = 'Transaction Id: '.$transaction_id.' <br/>
        Status: '.$status.' <br/>';

        Mail::send([], $email_data, function($message)  use ($email_data) {

            $message->to($email_data['to'] , $email_data['to_name'])
                ->subject($email_data['subject']);

            $message->from($email_data['from_email'] ,$email_data['from_name']);
            $message->setBody($email_data['email_content'], 'text/html');

        });
    }
}
