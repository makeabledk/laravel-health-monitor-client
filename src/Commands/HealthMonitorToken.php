<?php

namespace Makeable\HealthMonitorClient\Commands;

use Illuminate\Console\Command;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Str;

class HealthMonitorToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'health:token {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new health monitor token';

    public function handle()
    {
        $envFile = app()->environmentFilePath();

        abort_unless(file_exists($envFile), 400, 'No env file found');

        $env = file_get_contents($envFile);

        $token = sha1(Encrypter::generateKey(config('app.cipher')));

        if (! Str::contains($env, 'MONITOR_TOKEN=')) {
            $env = rtrim($env)."\n\nMONITOR_TOKEN=\n";
        } else {
            if (! $this->option('force')) {
                return $this->comment('Monitor token already set - skipping. Use force to regenerate token.');
            }
        }

        $env = preg_replace("/(MONITOR_TOKEN=)(.*)\n/", "$1\"{$token}\"\n", $env);

        file_put_contents($envFile, $env);

        $this->comment('Generated new monitor token: '.$token);
    }
}
