<?php

namespace Orca\Category\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Orca\Category\Models\Category::class,
        \Orca\Category\Models\CategoryTranslation::class,
    ];
}