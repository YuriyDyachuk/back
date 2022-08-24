<?php
declare(strict_types=1);

namespace Psr\Synchronizer\Contracts;

interface SynchronizerFactoryInterface
{
    public function makeSynchronizer(): SynchronizerInterface;
}
