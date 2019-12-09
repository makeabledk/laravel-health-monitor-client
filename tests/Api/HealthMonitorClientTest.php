<?php

namespace Makeable\HealthMonitorClient\Tests\Api;

use Illuminate\Foundation\Testing\TestResponse;
use Makeable\HealthMonitorClient\Tests\TestCase;

class HealthMonitorClientTest extends TestCase
{
    /** @test */
    public function it_checks_that_backup_health_check_is_included_in_health_check()
    {
        config()->set('monitor.token', 'secret');

        $response = $this->getJson('/health/check?token=secret');

        $data = json_decode($response->content(), true);
        $this->assertTrue(isset($data['Backup']));
    }

    /** @test */
    public function it_gives_an_unauthorized_error_when_token_is_wrong()
    {
        config()->set('monitor.api-token', 'right');

        $response = $this->getJson('/health/check?token=wrong');

        $actual = $response->getStatusCode();

        $this->assertTrue(
            401 === $actual,
            'Response status code ['.$actual.'] is not an unauthorized status code.'
        );
    }
}
