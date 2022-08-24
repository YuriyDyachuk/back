<?php
declare(strict_types=1);

namespace Psr\Synchronizer;

use Psr\Synchronizer\Contracts\SynchronizeAuditorInterface;

class Synchronizer implements Contracts\SynchronizerInterface
{
    /**
     * @var SynchronizeAuditorInterface[]
     */
    private array $syncAuditors;

    /**
     * Synchronizer constructor.
     *
     * @param SynchronizeAuditorInterface[] $synchronizeAuditors
     */
    public function __construct(array $synchronizeAuditors)
    {
        $this->syncAuditors = $synchronizeAuditors;
    }

    /**
     * @param int $lastSyncTimestamp
     *
     * @return bool[]
     */
    public function getStatues(int $lastSyncTimestamp): array
    {
        $statuses = [];
        foreach ($this->syncAuditors as $key => $auditor) {
            $statuses[$key] = $auditor->isSynchronized($lastSyncTimestamp);
        }

        return $statuses;
    }
}
