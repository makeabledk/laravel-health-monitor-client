<?php

namespace Makeable\HealthMonitorClient\Tests\Command;

use Illuminate\Support\Facades\Artisan;
use Makeable\HealthMonitorClient\Tests\TestCase;

class InstallCommandTest extends TestCase
{
    /**
     * @throws \Throwable
     */
    public function tearDown() : void
    {
        parent::tearDown();

        unlink(app()->environmentFilePath());
    }

    /** @test */
    public function it_install_a_token_and_publish_config_files()
    {
        Artisan::call('config:clear');
        Artisan::call('health:install');

        $this->assertFileExists(app()->environmentFilePath());
        $this->assertFileExists(app()->configPath().'/monitor.php');
        $this->assertFileExists(app()->configPath().'/health/config.php');
        $this->assertIsString(config('monitor.api-token'));
    }
}
