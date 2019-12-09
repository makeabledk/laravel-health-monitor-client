<?php

namespace Makeable\HealthMonitorClient\Checkers;

use PragmaRX\Health\Checkers\Base;
use PragmaRX\Health\Support\Result;
use Spatie\Backup\Tasks\Monitor\BackupDestinationStatus;
use Spatie\Backup\Tasks\Monitor\BackupDestinationStatusFactory;

class Backup extends Base
{
    /**
     * @return mixed|Result
     */
    public function check()
    {
        $statuses = BackupDestinationStatusFactory::createForMonitorConfig(config('backup.monitor_backups'));

        $statuses->filter(function (BackupDestinationStatus $backupDestinationStatus) {
            return $backupDestinationStatus->isHealthy();
        });

        if ($statuses->isEmpty()) {
            $this->makeResult(
                false,
                'The backups are considered unhealthy'
            );
        }

        return $this->makeHealthyResult();
    }
}
