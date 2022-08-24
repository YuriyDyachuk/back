<?php
declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

//    'facebook' => [
//        'client_id'     => '635354077144654',
//        'client_secret' => '2e1509853782afb93897144b96845c0d',
//        'redirect'      => 'https://back.patrul.app/api/login/facebook/callback',
//    ],
    'github' => [
        'client_id'     => 'b02fbae406e6739e5808',
        'client_secret' => '4e3119560b605c9b9d00fde9532fffd0526e5245',
        'redirect'      => 'https://back.patrul.app/api/login/github/callback',
    ],
    'facebook' => [
        'client_id'     => '635354077144654',
        'client_secret' => '2e1509853782afb93897144b96845c0d',
        'redirect'      => 'https://back.patrul.app/api/login/facebook/callback',
    ],
    'google' => [
        'client_id'     => '209532642655-h6ari9o782hbl8fb4botvmqdb6vsvm93.apps.googleusercontent.com',
        'client_secret' => 'QXFNQmP8wSF1heqSHDaHyIez',
        'redirect'      => 'https://back.patrul.app/api/login/google/callback',
    ],
    'apple' => [
        'client_id' => env('APPLE_CLIENT_ID'),
        'client_secret' => env('APPLE_CLIENT_SECRET'),
        'redirect' => env('APPLE_REDIRECT_URI')
    ],
];
