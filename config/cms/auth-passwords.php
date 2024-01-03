<?php

return [
    'cms' => [
        'provider' => 'cms',
        'table' => 'admin_password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
    ],
];
