<?php

namespace Orca\Customer\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Orca\Customer\Models\Customer::class,
        \Orca\Customer\Models\CustomerAddress::class,
        \Orca\Customer\Models\CustomerGroup::class,
    ];
}