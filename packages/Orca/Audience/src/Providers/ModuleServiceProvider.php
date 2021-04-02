<?php

namespace Orca\Audience\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Orca\Audience\Models\User::class,
        \Orca\Audience\Models\UserAddress::class,
        \Orca\Audience\Models\UserGroup::class,
    ];
}