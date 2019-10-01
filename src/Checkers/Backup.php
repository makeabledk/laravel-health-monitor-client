<?php


namespace Makeable\HealthMonitorClient\Checkers;

use PragmaRX\Health\Checkers\Base;
use PragmaRX\Health\Support\Result;
use Spatie\Backup\Tasks\Monitor\BackupDestinationStatusFactory;

class Backup extends Base
{
    /**
     * @return mixed|Result
     */
    public function check()
    {
        dd('her');
        $statuses = BackupDestinationStatusFactory::createForMonitorConfig(config('backup.monitor_backups'));

        $statuses->each(function (BackupDestinationStatus $backupDestinationStatus) {
            $diskName = $backupDestinationStatus->backupDestination()->diskName();

            if ($backupDestinationStatus->isHealthy()) {
                $this->info("The backups on {$diskName} are considered healthy.");
                return;
            }

            $this->error("The backups on {$diskName} are considered unhealthy!");
        });


        return $this->makeResult(
            true,
            'the fudge'
        );
    }
}
