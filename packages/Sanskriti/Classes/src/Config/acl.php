<?php

return [
    <?php

return [
    [
        'key' => 'classes.read',
        'name' => 'Class',
        'scopes' => [
            'classes.read',
            'classes.*'
        ],
        'routes' => [
            'admin.classes.index'
        ]
    ], [
        'key' => 'classes.create',
        'name' => 'Add Class',
        'scopes' => [
            'classes.*',
            'classes.create'
        ],
        'routes' => [
            'admin.classes.create',
            'admin.classes.store'
        ]
    ], [
        'key' => 'classes.update',
        'name' => 'Update Class',
        'scopes' => [
            'classes.*',
            'classes.update'
        ],
        'routes' => [
            'admin.classes.edit',
            'admin.classes.store'
        ]
    ], [
        'key' => 'classes.delete',
        'name' => 'Delete Class',
        'scopes' => [
            'classes.*',
            'classes.delete'
        ],
        'routes' => [
            'admin.classes.destroy'
        ]
    ]
];
];