<?php

namespace Ecommvu\Transcriber\Providers;

use Illuminate\Support\ServiceProvider;

class TranscriberServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     * Router $router
     * @return void
     */
    public function boot()
    {
        // include __DIR__ . '/../Http/helpers.php';

        // $router->aliasMiddleware('admin', BouncerMiddleware::class);
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');

        $this->loadViewsFrom(__DIR__, '/../Resources/views', 'transcriber');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/menu.php', 'menu.admin'
        );
    }
}
