<?php
/**
 * Created by v.taneev.
 */


namespace App\Clients;


use App\Models\Request;

class OrderTelegramClient extends AbstractTelegramClient
{

    protected function getConfiguration() {
        return config('telegram')['orders'];
    }

    protected function getBotKey ()
    {
        return $this->getConfiguration()['bot_key'];
    }

    protected function getChatId ()
    {
        return $this->getConfiguration()['chat_id'];
    }

    public function sendOrderInfo(Request $request) {
        $userId = $request->user_id;
        $userData = AuthServiceClient::getInstance()->getUserById($userId);
        $message = "Компании \"{$userData['name']}\" выдан займ в размере {$request->amount} руб. на {$request->term} мес. под {$request->product->credit_rate}% годовых";
        return $this->sendMessage($message);
    }
}
