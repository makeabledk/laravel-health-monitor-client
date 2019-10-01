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

        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $str = strtok($str, '=').'=';

        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
    }

    /** @test */
    public function it_test_an_command()
    {
        Artisan::call('health:install');

        $this->assertIsString(config('monitor.api-token'));
    }
}
