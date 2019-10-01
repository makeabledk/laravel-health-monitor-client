<?php


namespace Makeable\HealthMonitorClient\Tests\Command;

use Illuminate\Support\Facades\Artisan;
use Makeable\HealthMonitorClient\Tests\TestCase;

class InstallCommandTest extends TestCase
{
    /** @test */
    public function it_test_an_command()
    {
        Artisan::call('health:install');
        Artisan::output();
    }
}
