<?php

namespace Makeable\HealthMonitorClient\Tests\Command;

use Illuminate\Support\Facades\Artisan;
use Makeable\HealthMonitorClient\Tests\TestCase;

class InstallCommandTest extends TestCase
{
    /** @test */
    public function it_install_a_token_and_publish_config_files()
    {
        copy($this->app->environmentFilePath().'.example', $this->app->environmentFilePath());

        Artisan::call('health:install');

        $this->assertFileExists(app()->configPath().'/monitor.php');
        $this->assertFileExists(app()->configPath().'/health/config.php');
        $this->assertIsString(config('monitor.token'));
    }
}
