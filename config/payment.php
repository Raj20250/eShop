<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Payment Gateway Configurations
    |--------------------------------------------------------------------------
    |
    | This configuration file contains payment gateway credentials.
    |
    */

    'default' => env('PAYMENT_GATEWAY', 'jazzcash'),

    'jazzcash' => [
        'merchant_id' => env('JAZZCASH_MERCHANT_ID', ''),
        'merchant_password' => env('JAZZCASH_MERCHANT_PASSWORD', ''),
        'pp_version' => env('JAZZCASH_PP_VERSION', '1.1'),
        'language' => env('JAZZCASH_LANGUAGE', 'en'),
        'currency' => env('JAZZCASH_CURRENCY', 'GBP'),
        'sandbox' => env('APP_DEBUG', true),
    ],

    'stripe' => [
        'key' => env('STRIPE_KEY', ''),
        'secret' => env('STRIPE_SECRET', ''),
    ],

    'paypal' => [
        'mode' => env('PAYPAL_MODE', 'sandbox'),
        'client_id' => env('PAYPAL_CLIENT_ID', ''),
        'client_secret' => env('PAYPAL_CLIENT_SECRET', ''),
    ],
];
