<?php


use Illuminate\Console\Command;
use Spatie\Backup\Events\HealthyBackupWasFound;
use Spatie\Backup\Events\UnhealthyBackupWasFound;
use Spatie\Backup\Tasks\Monitor\BackupDestinationStatus;
use Spatie\Backup\Tasks\Monitor\BackupDestinationStatusFactory;

class BackupHealthCheck extends Command
{
    public function handle()
    {
        $statuses = BackupDestinationStatusFactory::createForMonitorConfig(config('backup.monitor_backups'));

        $statuses->each(function (BackupDestinationStatus $backupDestinationStatus) {
            $diskName = $backupDestinationStatus->backupDestination()->diskName();

            if ($backupDestinationStatus->isHealthy()) {
                $this->info("The backups on {$diskName} are considered healthy.");
                event(new HealthyBackupWasFound($backupDestinationStatus));

                return;
            }

            $this->error("The backups on {$diskName} are considered unhealthy!");
            event(new UnHealthyBackupWasFound($backupDestinationStatus));
        });
    }
}
