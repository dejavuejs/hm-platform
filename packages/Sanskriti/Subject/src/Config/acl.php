<?php

return [
    [
        'key' => 'subject.read',
        'name' => 'Subject',
        'scopes' => [
            'subject.read',
            'subject.^'
        ],
        'routes' => [
            'admin.subject.index'
        ]
    ], [
        'key' => 'subject.create',
        'name' => 'Add Subject',
        'scopes' => [
            'subject.*',
            'subject.create'
        ],
        'routes' => [
            'admin.subject.create',
            'admin.subject.store'
        ]
    ], [
        'key' => 'subject.update',
        'name' => 'Update Subject',
        'scopes' => [
            'subject.*',
            'subject.update'
        ],
        'routes' => [
            'admin.subject.edit',
            'admin.subject.store'
        ]
    ], [
        'key' => 'subject.delete',
        'name' => 'Delete Subject',
        'scopes' => [
            'subject.*',
            'subject.delete'
        ],
        'routes' => [
            'admin.subject.destroy'
        ]
    ]
];