<?php

namespace Orca\Audience\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Orca\Audience\Http\Middleware\RedirectIfNotAudience;

class AudienceServiceProvider extends ServiceProvider
{
    public function boot(Router $router)
    {
        $router->aliasMiddleware('audience', RedirectIfNotAudience::class);

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'audience');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
