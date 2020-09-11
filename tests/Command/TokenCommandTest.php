<?php

namespace Makeable\HealthMonitorClient\Tests\Command;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Makeable\HealthMonitorClient\Tests\TestCase;

class TokenCommandTest extends TestCase
{
    /** @test */
    public function it_installs_a_token_to_the_env_file()
    {
        Artisan::call('health:token');

        $this->assertStringContainsString('Generated new monitor token:', $output = Artisan::output());
        $this->assertTokenInstalledFromOutput($output);
    }

    /** @test **/
    public function it_requires_force_when_already_have_token()
    {
        // First
        Artisan::call('health:token');
        $this->assertStringContainsString('Generated new monitor token:', $firstOutput = Artisan::output());
        $this->assertTokenInstalledFromOutput($firstOutput);

        // Second
        Artisan::call('health:token');
        $this->assertStringContainsString('skipping', Artisan::output());
        $this->assertTokenInstalledFromOutput($firstOutput);

        // Final
        Artisan::call('health:token', ['--force' => true]);
        $this->assertStringContainsString('Generated new monitor token:', $newOutput = Artisan::output());
        $this->assertTokenInstalledFromOutput($newOutput);
    }

    protected function assertTokenInstalledFromOutput($output)
    {
        $token = trim(Str::after($output, ': '));
        $this->assertGreaterThan(10, strlen($token));
        $this->assertStringContainsString("MONITOR_TOKEN=\"{$token}\"", file_get_contents($this->app->environmentFilePath()));
    }
}
