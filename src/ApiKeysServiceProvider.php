<?php

namespace Savannabits\ApiKeys;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class ApiKeysServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(Router $router)
    {
        $this->registerMiddleware($router);
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'api-keys');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'api-keys');
//        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('api-keys.php'),
            ], 'savannabits-apikeys-config');

            $this->publishesMigrations([
                __DIR__.'/../database/migrations/create_api_keys_table.php' => database_path('migrations/'. date('Y_m_d_His', time()).'_create_api_keys_table.php'),
                __DIR__.'/../database/migrations/create_api_key_events_table.php' => database_path('migrations/'. date('Y_m_d_His', time()).'_create_api_key_events_table.php'),
            ], 'savannabits-apikeys-migrations');

            
            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/api-keys'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'api-keys');

        // Register the main class to use with the facade
        $this->app->singleton('api-keys', function () {
            return new ApiKeys();
        });
    }

    protected function registerMiddleware(Router $router): void
    {
        $router->aliasMiddleware('auth.apikey', Http\Middleware\AuthorizeApiKey::class);
    }
}
