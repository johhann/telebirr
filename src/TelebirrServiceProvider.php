<?php

namespace Johhann\Telebirr;

use Illuminate\Support\ServiceProvider;
use Johhann\Telebirr\Console\InstallConfigFile;

class TelebirrServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'johhann');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'johhann');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/telebirr.php', 'telebirr');

        // Register the service the package provides.
        $this->app->singleton('telebirr', function ($app) {
            return new Telebirr;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['telebirr'];
    }

    /**
     * Console-specific booting.
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/telebirr.php' => config_path('telebirr.php'),
        ], 'telebirr.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/johhann'),
        ], 'telebirr.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/johhann'),
        ], 'telebirr.assets');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/johhann'),
        ], 'telebirr.lang');*/

        // Registering package commands.
        $this->commands([
            InstallConfigFile::class,
        ]);
    }
}
