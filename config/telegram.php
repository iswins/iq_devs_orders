<?php
/**
 * Created by v.taneev.
 */

return [
    'orders' => [
        'bot_key' => getenv('TG_ORDERS_TOKEN', null),
        'chat_id' => getenv('TG_ORDERS_CHAT', null),
    ]
];
