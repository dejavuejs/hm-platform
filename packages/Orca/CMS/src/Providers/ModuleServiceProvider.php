<?php

namespace Orca\CMS\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Orca\CMS\Models\CMS::class
    ];
}