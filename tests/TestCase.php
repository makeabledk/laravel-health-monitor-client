<?php

namespace Makeable\HealthMonitorClient\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Makeable\HealthMonitorClient\HealthMonitorClientServiceProvider;
use PragmaRX\Health\ServiceProvider;

class TestCase extends BaseTestCase
{
    public function createApplication()
    {
        $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();

        $app->register(ServiceProvider::class);
        $app->register(HealthMonitorClientServiceProvider::class);

        Artisan::call('vendor:publish', [
            '--provider' => 'Makeable\HealthMonitorClient\HealthMonitorClientServiceProvider',
            '--force' => true,
        ]);

        return $app;
    }

    public function setUp(): void
    {
        parent::setUp();

        @unlink($file = $this->app->environmentFilePath());

        copy(
            app()->environmentFilePath().'.example',
            app()->environmentFilePath()
        );
    }
}
