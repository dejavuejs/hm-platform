<?php

namespace Ecommvu\Marketing\Providers;

use Ecommvu\Core\Providers\CoreModuleServiceProvider;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    protected $models = [
        \Ecommvu\Marketing\Models\Campaign::class,
        \Ecommvu\Marketing\Models\Template::class,
        \Ecommvu\Marketing\Models\Event::class,
    ];
}