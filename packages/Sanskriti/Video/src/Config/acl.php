<?php

return [
    [
        'key' => 'video.read',
        'name' => 'Video',
        'scopes' => [
            'video.read',
            'video.*'
        ],
        'routes' => [
            'admin.video.index'
        ]
    ], [
        'key' => 'video.create',
        'name' => 'Add Video',
        'scopes' => [
            'video.*',
            'video.create'
        ],
        'routes' => [
            'admin.video.create',
            'admin.video.store'
        ]
    ], [
        'key' => 'video.update',
        'name' => 'Update Video',
        'scopes' => [
            'video.*',
            'video.update'
        ],
        'routes' => [
            'admin.video.edit',
            'admin.video.store'
        ]
    ], [
        'key' => 'video.delete',
        'name' => 'Delete Video',
        'scopes' => [
            'video.*',
            'video.delete'
        ],
        'routes' => [
            'admin.video.destroy'
        ]
    ]
];