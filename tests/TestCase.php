<?php

namespace Makeable\HealthMonitorClient\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Makeable\HealthMonitorClient\HealthMonitorClientServiceProvider;
use Makeable\HealthMonitorClient\Tests\Helpers\TestHelpers;
use PragmaRX\Health\ServiceProvider;

class TestCase extends BaseTestCase
{
    use TestHelpers;

    /**
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        putenv('APP_ENV=testing');
        putenv('APP_DEBUG=true');

        $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();
        $app->register(HealthMonitorClientServiceProvider::class);
        $app->register(ServiceProvider::class);

        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite.database', ':memory:');

        return $app;
    }
}
