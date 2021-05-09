<?php

namespace Ecommvu\DNS\Providers;

use Gate;
use Illuminate\Routing\Router;
use Illuminate\Foundation\AliasLoader;
use Ecommvu\DNS\AppStore;
use Ecommvu\AppStore\Facades\AppStore as AppStoreFacade;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class DNSServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for DNS application.
     *
     * @var array
     */
    protected $policies = [
        \Ecommvu\DNS\Models\DNS::class => \Ecommvu\DNS\Policies\DNSPolicy::class
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->registerPolicies();

        $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'dns');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'dns');

        Gate::define('view', 'Ecommvu\DNS\Policies\DNSPolicy@view');
        Gate::define('create', 'Ecommvu\DNS\Policies\DNSPolicy@create');

        $this->app->bind(AppInterface::class, AppStore::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/plan.php', 'subscription-apps.monthly.dns'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/menu.php', 'menu.admin'
        );

        $this->registerFacades();
    }

    /**
     * Register AppStore as a singleton.
     *
     * @return void
     */
    protected function registerFacades()
    {
        $loader = AliasLoader::getInstance();

        $loader->alias('appstore', AppStoreFacade::class);

        $this->app->singleton('appstore', function () {
            return app()->make(AppStore::class);
        });
    }
}