<?php

namespace Orca\User\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Orca\User\Models\Admin::class,
        \Orca\User\Models\Role::class,
    ];
}