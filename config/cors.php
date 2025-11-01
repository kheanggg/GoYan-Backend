<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],
    'allowed_origins' => [
        env('MINI_APP_URL', 'https://go-yan-frontend.vercel.app'),
        'https://t.me',
        'http://localhost:3000',
        'https://95b2f9276052.ngrok-free.app',
    ],
    'allowed_headers' => ['*'],
    'supports_credentials' => true,
];