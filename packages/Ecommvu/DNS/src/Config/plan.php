<?php

return [
    'name' => 'DNS App',
    'code' => 'dns',
    'cost' => 3.99,
    'version' => '0.1.0',
    'free' => false,
    'guards' => [
        // Involves strict type checking for guards and the functionality create / alter user flows
        'admin'
    ],
    'description' => [
        'text' => 'Monthly plan features',
        'features' => [
            'Apply custom domain over your own shop',
            'Have control over custom domain'
        ]
    ],
    'scopes' => [
        'dns.*',
        'dns.create',
        'dns.update',
        'dns.delete',
        'dns.view'
    ],
    'scope_assist' => true,
    'activation' => [
        [
            'instance' => 'Ecommvu\DNS\Jobs\ActivationJob::class',
            'auth' => [
                'guard' => [
                    'admin'
                ],
                'logged_in' => true,
                'permission_type' => 'all,*,*.*,dns.*'
            ]
        ]
    ],
    'deactivation' => [
        [
            'instance' => 'Ecommvu\DNS\Jobs\DeactivationJob::class',
            'auth' => [
                'guard' => [
                    'admin'
                ],
                'logged_in' => true,
                'permission_type' => 'all,*,*.*,dns.*'
            ]
        ]
    ],
    'trial' => false,
    'trial_days' => 0,
    'status' => true
];