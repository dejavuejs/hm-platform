<?php

namespace Sanskriti\Video\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class VideoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadRoutesFrom(__DIR__ . '/../Http/admin-routes.php');

        // $this->loadRoutesFrom(__DIR__ . '/../Http/shop-routes.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'video');

        // $this->publishes([
        //     __DIR__ . '/../../publishable/assets' => public_path('themes/default/assets')
        // ], 'public');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'video');

        // Event::listen('bagisto.admin.layout.head', function($viewRenderEventManager) {
        //     $viewRenderEventManager->addTemplate('video::admin.layouts.style');
        // });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/admin-menu.php', 'menu.admin'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/acl.php', 'acl'
        );
    }
}