<?php
/**
 * Created by v.taneev.
 */

return [
    'auth' => [
        'url' => getenv('AUTH_SERVICE_URL', 'http://localhost:7081'),
        'timeout' => getenv('AUTH_SERVICE_TIMEOUT', 2)
    ]
];
