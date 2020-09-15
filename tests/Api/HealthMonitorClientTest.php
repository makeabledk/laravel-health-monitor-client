<?php

namespace Makeable\HealthMonitorClient\Tests\Api;

use Makeable\HealthMonitorClient\Tests\TestCase;

class HealthMonitorClientTest extends TestCase
{
    /** @test */
    public function it_checks_that_backup_health_check_is_included_in_health_check()
    {
        config()->set('monitor.token', 'secret');

        $this
            ->getJson('/health/check?token=secret')
            ->assertSuccessful()
            ->assertJsonStructure([
                'AppKey' => ['id', 'name', 'targets'],
            ]);
    }

    /** @test */
    public function it_gives_an_unauthorized_error_when_token_is_wrong()
    {
        config()->set('monitor.api-token', 'right');

        $this
            ->getJson('/health/check?token=wrong')
            ->assertStatus(401);
    }
}
