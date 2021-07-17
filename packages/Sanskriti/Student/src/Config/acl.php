<?php

return [
    [
        'key' => 'student.read',
        'name' => 'Student',
        'scopes' => [
            'student.*',
            'student.^'
        ],
        'routes' => [
            'admin.student.index'
        ]
    ], [
        'key' => 'student.create',
        'name' => 'Add Student',
        'scopes' => [
            'student.*',
            'student.create'
        ],
        'routes' => [
            'admin.student.create',
            'admin.student.store'
        ]
    ], [
        'key' => 'student.update',
        'name' => 'Update Student',
        'scopes' => [
            'student.*',
            'student.update'
        ],
        'routes' => [
            'admin.student.edit',
            'admin.student.store'
        ]
    ]
];