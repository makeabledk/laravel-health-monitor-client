<?php


namespace Makeable\HealthMonitorClient\Tests\Feature;

use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Facades\Artisan;
use Makeable\HealthMonitorClient\Tests\TestCase;

class HealthMonitorClientTest extends TestCase
{
    /** @test */
    public function it_checks_that_health_monitor_is_included_in_health_check()
    {
        config()->set('monitor.api-token', 'secret');

        $this
            ->getJson('/health/check?token=secret')
            ->tap(function (TestResponse $response) {
                $data = json_decode($response->content(), true);
                dd($data);
            });
    }
}
