<?php
declare(strict_types=1);

namespace App\Components\EntitiesSynchronizer\Contracts\Presenters;

interface EntitySyncStatusPresenterInterface
{
    public function format(bool $status, array $meta): array;
}
