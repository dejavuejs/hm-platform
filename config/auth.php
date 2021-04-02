<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'admins',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'api' => [
            'driver' => 'jwt',
            'provider' => 'audiences',
        ],

        'audience' =>[
            'driver' => 'session',
            'provider' => 'audiences'
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins'
        ],

        'admin-api' => [
            'driver' => 'token',
            'provider' => 'admins',
        ]
    ],

    'providers' => [
        'audiences' => [
            'driver' => 'eloquent',
            'model' => Orca\Audience\Models\Audience::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => Orca\User\Models\Admin::class,
        ]
    ],

    'passwords' => [
        'admins' => [
            'provider' => 'admins',
            'table' => 'admin_password_resets',
            'expire' => 60,
        ],
        'audiences' => [
            'provider' => 'audiences',
            'table' => 'audience_password_resets',
            'expire' => 60,
        ],
    ],
];
