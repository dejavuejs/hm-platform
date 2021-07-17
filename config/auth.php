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
            'driver' => 'passport',
            'provider' => 'customers',
        ],

        'customer' =>[
            'driver' => 'session',
            'provider' => 'customers'
        ],

        'customer' =>[
            'driver' => 'session',
            'provider' => 'customers'
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins'
        ],

        'admin-api' => [
            'driver' => 'passport',
            'provider' => 'admins',
        ]
    ],

    'providers' => [
        'customers' => [
            'driver' => 'eloquent',
            'model' => Orca\Customer\Models\Customer::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => Orca\User\Models\Admin::class,
        ],

        'students' => [
            'driver' => 'eloquent',
            'model' => Orca\Student\Models\Student::class,
        ]
    ],

    'passwords' => [
        'admins' => [
            'provider' => 'admins',
            'table' => 'admin_password_resets',
            'expire' => 60,
        ],
        'customers' => [
            'provider' => 'customers',
            'table' => 'customer_password_resets',
            'expire' => 60,
        ],
        'students' => [
            'provider' => 'students',
            'table' => 'students_password_resets',
            'expire' => 60,
        ],
    ],
];
