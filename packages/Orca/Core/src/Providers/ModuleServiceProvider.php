<?php

namespace Orca\Core\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Orca\Core\Models\Channel::class,
        \Orca\Core\Models\CoreConfig::class,
        \Orca\Core\Models\Country::class,
        \Orca\Core\Models\CountryState::class,
        \Orca\Core\Models\Currency::class,
        \Orca\Core\Models\CurrencyExchangeRate::class,
        \Orca\Core\Models\Locale::class,
        \Orca\Core\Models\Slider::class,
        \Orca\Core\Models\SubscribersList::class
    ];
}