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

        foreach ($statuses as $backupDestinationStatus) {
            if (!$backupDestinationStatus->isHealthy()) {
                return $this->makeResult(
                    false,
                    $backupDestinationStatus->getHealthCheckFailure()->exception()->getMessage()
                );
            }
        };

        return $this->makeHealthyResult();
    }
}
