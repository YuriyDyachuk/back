<?php
declare(strict_types=1);

namespace Psr\Synchronizer\Contracts;

interface SynchronizableFactoryInterface
{
    public function makeSynchronizable(): SynchronizableInterface;
}
