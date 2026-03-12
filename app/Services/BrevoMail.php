<?php

namespace App\Services;

use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Configuration;
use GuzzleHttp\Client;

class BrevoMail
{
    public static function send($to, $subject, $html)
    {
        $config = Configuration::getDefaultConfiguration()
            ->setApiKey('api-key', config('services.brevo.key'));

        $apiInstance = new TransactionalEmailsApi(
            new Client(),
            $config
        );

        $email = new \Brevo\Client\Model\SendSmtpEmail([
            'subject' => $subject,
            'htmlContent' => $html,
            'sender' => [
                'name' => config('app.name'),
                'email' => config('mail.from.address')
            ],
            'to' => [
                ['email' => $to]
            ]
        ]);

        $apiInstance->sendTransacEmail($email);
    }
}