<?php
declare(strict_types=1);

namespace Psr\Synchronizer;

use Psr\Synchronizer\Contracts\SynchronizeAuditorInterface;
use Psr\Synchronizer\Contracts\SynchronizerInterface;

class SynchronizerFactory implements Contracts\SynchronizerFactoryInterface
{
    /**
     * @var SynchronizeAuditorInterface[]
     */
    private array $synchronizeAuditors;

    /**
     * SynchronizerFactory constructor.
     *
     * @param SynchronizeAuditorInterface[] $synchronizeAuditors
     */
    public function __construct(array $synchronizeAuditors)
    {
        $this->synchronizeAuditors = $synchronizeAuditors;
    }

    public function makeSynchronizer(): SynchronizerInterface
    {
        return new Synchronizer($this->synchronizeAuditors);
    }
}
