<?php

namespace Ecommvu\Marketing\Providers;

use Illuminate\Support\ServiceProvider;
use Ecommvu\Marketing\Console\Commands\EmailsCommand;
use Illuminate\Console\Scheduling\Schedule;

class MarketingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');

        $this->loadViewsFrom(__DIR__, '/../Resources/views', 'marketing');

        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->command('campaign:process')->daily();
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([EmailsCommand::class]);
        }

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/menu.php', 'menu.admin'
        );
    }
}