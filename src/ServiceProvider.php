<?php

namespace ArtisanLogo;

use Illuminate\Console\Application as Artisan;
use Figlet\Figlet;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->publishes([__DIR__ . '/config' => config_path('logo')], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/logo.php', 'logo');

        $config = $this->app['config'];
        if ($config->get('logo.enabled', false)) {
            Artisan::starting(
                function ($artisan) use ($config) {
                    $artisan->setName(
                        (new Figlet($config->get('logo', [])))->render($config->get('app.name'))
                    );
                }
            );
        }
    }
}