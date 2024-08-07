<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'exchange-api' => [
        'default' => 'fixer',
        'fixer' => [
            'paid_account' => false,
            'key' => env('fixer_api_key'),
            'class' => 'Orca\Core\Helpers\Exchange\FixerExchange'
        ]
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'assembly_ai' => [
        'key' => env('ASSEMBLY_AI_KEY')
    ],

    'chat_gpt' => [
        'endpoint' => 'https://api.openai.com',
        'key' => env('CHAT_GPT_KEY'),
        'feedback_gpt_id' => env('FEEDBACK_GPT_ID', 'asst_GXBDQuIZ2FTXgrtcdJo8cjFA'),
        'prescription_gpt_id' => env('PRESCRIPTION_GPT_ID', 'asst_fcRvEVuKaRM7trzU8YjMXM3W'),
        'assistant_gpt_id' => env('ASSISTANT_GPT_ID', 'asst_J4bhCM9HWSsesVO9o150hWse')
    ]
];
