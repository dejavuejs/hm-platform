<?php

namespace Ecommvu\Marketing\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Ecommvu\Marketing\Models\Campaign::class,
        \Ecommvu\Marketing\Models\Template::class,
        \Ecommvu\Marketing\Models\Event::class,
    ];
}