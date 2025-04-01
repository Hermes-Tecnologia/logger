<?php

namespace HermesTecnologia\Logger;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log as MonoLogger;

class LoggerServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'hermes-tecnologia');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'hermes-tecnologia');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/logger.php', 'logger');

        // Register the service the package provides.
        $this->app->singleton('logger', function ($app) {
            return new Logger();
        });

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/logger.php' => config_path('logger.php'),
            ], 'config');

            MonoLogger::info('register', [__DIR__.'/../config/logger.php', config_path('logger.php'), file_exists(__DIR__.'/../config/logger.php')]);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['logger'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/logger.php' => config_path('logger.php'),
        ], 'config');

        MonoLogger::info('bootForConsole', [__DIR__.'/../config/logger.php', config_path('logger.php'), file_exists(__DIR__.'/../config/logger.php')]);

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/hermes-tecnologia'),
        ], 'logger.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/hermes-tecnologia'),
        ], 'logger.assets');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/hermes-tecnologia'),
        ], 'logger.lang');*/

        // Registering package commands.
        $this->commands([
            InstallLoggerPackage::class
        ]);
    }
}
