<?php

namespace Makeable\HealthMonitorClient;

use Illuminate\Support\ServiceProvider;
use Makeable\HealthMonitorClient\Commands\HealthMonitorInstall;
use Makeable\HealthMonitorClient\Commands\HealthMonitorToken;
use Makeable\HealthMonitorClient\Middleware\HealthMonitorAuthentication;

class HealthMonitorClientServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                HealthMonitorInstall::class,
                HealthMonitorToken::class,
            ]);
        }

        app('router')->aliasMiddleware('health-api', HealthMonitorAuthentication::class);
    }

    public function register()
    {
        $this->mergeConfig();

        $this->configurePaths();
    }

    private function configurePaths()
    {
        $this->publishes(
            [
                __DIR__.'/config/health.php' => config_path(
                    'health/config.php'
                ),
                __DIR__.'/config/monitor.php' => config_path(
                    'monitor.php'
                ),
                __DIR__.'/config/resources/' => config_path(
                    'health/resources/'
                ),
            ],
            'config'
        );
    }

    /**
     * Merge configuration.
     */
    private function mergeConfig()
    {
        if (file_exists(config_path('/health/config.php'))) {
            $this->mergeConfigFrom(config_path('/health/config.php'), 'health');
        }

        $this->mergeConfigFrom(__DIR__.'/config/health.php', 'health');

        $this->mergeConfigFrom(__DIR__.'/config/monitor.php', 'monitor');
    }
}
