<?php
declare(strict_types=1);

namespace Psr\Synchronizer\Contracts;

interface SynchronizeAuditorFactoryInterface
{
    public function makeAuditor(): SynchronizeAuditorInterface;
}
