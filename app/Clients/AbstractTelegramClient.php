<?php
/**
 * Created by v.taneev.
 */


namespace App\Clients;


use GuzzleHttp\Client;

abstract class AbstractTelegramClient
{
    abstract protected function getBotKey();
    abstract protected function getChatId();

    public function sendMessage ($message)
    {
        $url = "https://api.telegram.org/bot{$this->getBotKey()}/sendmessage";
        $params = [
            'text'    => $message,
            'chat_id' => $this->getChatId() . '^',
            'parse_mode' => 'HTML'
        ];

        return (new Client())->get($url, ['query' => $params]);
    }
}
