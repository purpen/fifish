<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    
    'facebook' => [
        'client_id' => '163101587483903',
        'client_secret' => 'your-github-app-secret',
        'redirect' => env('APP_URL', 'https://api.qysea.com').'/oauth/callback/facebook',
    ],
    
    'wechat' => [
        'client_id' => 'wx5d74f772a28a33a4',
        'client_secret' => 'f3fdb3d58250d0444924076b168ba492',
        'redirect' => env('APP_URL', 'https://api.qysea.com').'/oauth/callback/wechat',
    ],
    
    'instagram' => [
        'client_id' => '1c54a1a8da6b4b5e939501d1cfdb3a93',
        'client_secret' => 'ce739bb3302c4261a39e29d623428317',
        'redirect' => env('APP_URL', 'https://api.qysea.com').'/oauth/callback/instagram',
    ],
    
    
];
