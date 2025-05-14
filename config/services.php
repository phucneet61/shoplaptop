<?php

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

    'facebook' => [
        'client_id' => '990518783179394',  //client face của bạn
        'client_secret' => '601b33c944bef88dee6f7bcccb896131',  //client app service face của bạn
        'redirect' => 'http://localhost/shop-laptop_laravel_9/admin/callback' //callback trả về
    ],

    'google' => [
        'client_id' => '854495474920-f4kebuuu4bfochj8ni4ck8q5ki12v1uq.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://localhost/shop-laptop_laravel_9/google/callback' 
    ],


];
