<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TelegramService
{
    protected $token = '7502736303:AAGNbJw9DUn5sBdPW3TuWMJikIT3bBFk45s';

    public function sendMessage($chat_id, $message)
    {
        $url = "https://api.telegram.org/bot{$this->token}/sendMessage";

        Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8'
        ])->post($url, [
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'HTML',
        ]);
    }
}
