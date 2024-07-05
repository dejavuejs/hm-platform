<?php

namespace Ecommvu\Transcriber\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Ecommvu\Transcriber\Models\PatientConsultation::class,
    ];
}