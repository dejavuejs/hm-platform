<?php

namespace Ecommvu\Authorization\Providers;

use Gate;
use Illuminate\Routing\Router;
use Ecommvu\Authorization\Helpers\ACL;
use Ecommvu\Authorization\Facades\ACL as ACLFacade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * ACL Service provider for handling ACL and policies through out all resources
 */
class AuthorizationServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for DNS application.
     *
     * @var array
     */
    protected $policies = [
        App\Models\User::class => \ZapInv\User\Policies\UserPolicy::class
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->setScopes();

        if (request()->is('*')) {
            try {
                \ACL::validateScopes();
            } catch (\Exception $e) {
                \Log::critical("API scope tokens validation failure" . $e->getMessage());

                abort(401);
            }
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes(
            [
                __DIR__ . '/../Config/scopes.php' => config_path('scopes.php')
            ],
            'acl-config'
        );

        $this->registerFacades();
    }

    /**
     * Set the scopes for current booted callback, usage of static variable is preferred
     */
    public function setScopes()
    {
        // Gate::define('v-dn', 'Ecommvu\DNS\Policies\DNSPolicy@create');
    }

    /**
     * Register Bouncer as a singleton.
     *
     * @return void
     */
    protected function registerFacades()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('acl', ACLFacade::class);

        $this->app->singleton(
            'acl', function () {
                return app()->make(ACL::class);
            }
        );
    }
}
