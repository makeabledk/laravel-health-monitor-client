<?php

namespace Makeable\HealthMonitorClient\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Makeable\HealthMonitorClient\HealthMonitorClientServiceProvider;

class HealthMonitorInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'health:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install health monitor client';

    public function handle()
    {
        Artisan::call('vendor:publish', [
            '--provider' => HealthMonitorClientServiceProvider::class,
            '--force' => true,
        ]);

        Artisan::call('health:token');

        $this->info('Health monitor installed');
    }
}
