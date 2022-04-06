<?php

namespace Helper;

use GuzzleHttp\Client;

class NotificationHandler
{
    public static function buildRequestUrl($body)
    {
        $telegram_boot_token = env('TELEGRAM_BOT_TOKEN');
        $telegram_chat_id = env('TELEGRAM_CHAT_ID');

        $messageBody = $body;

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => "https://api.telegram.org/bot{$telegram_boot_token}/sendMessage?chat_id={$telegram_chat_id}&text={$messageBody}",
            // You can set any number of default request options.
            'timeout'  => 10.0,
        ]);
        $response = $client->request('GET');
    }
}