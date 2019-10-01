<?php

namespace Makeable\HealthMonitorClient\Commands;

use Illuminate\Console\Command;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Artisan;

class HealthMonitorClientInstall extends Command
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
            '--provider' => 'Makeable\HealthMonitorClient\HealthMonitorClientServiceProvider',
            '--force' => true,
        ]);

        if (! getenv('HEALTH_TOKEN')) {
            if (! file_exists(app()->environmentFilePath())) {
                copy(__DIR__.'../../env.example', app()->environmentFilePath());
            }
            $this->setEnvHealthToken();
        }

        $this->info('Health monitor installed');
    }

    protected function setEnvHealthToken()
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $token = base64_encode(Encrypter::generateKey($this->laravel['config']['app.cipher']));

        $str = str_replace('HEALTH_TOKEN=', "HEALTH_TOKEN={$token}\n", $str);

        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);

        $this->info('New Health Monitor Token: '.$token);
    }
}
