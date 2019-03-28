<?php

namespace Ops\Providers;

use Illuminate\Support\ServiceProvider;

class OpsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if (file_exists(config_path('ops.php'))) {
            $this->mergeConfigFrom(config_path('ops.php'), 'ops');
        } else {
            $this->mergeConfigFrom(__DIR__ . '/../../config/ops.php', 'ops');
        }

        $this->app->singleton('ops', function ($app) {
            return new DingHelper(
                config('ops.app_id'),
                config('ops.secret_key')
            );
        });
    }
}