<?php
declare(strict_types=1);

namespace App\Components\SuperCategorySynchronizer\Presenters;

use App\Components\EntitiesSynchronizer\Contracts\Presenters\EntitySyncStatusPresenterInterface;

class SuperCategorySyncStatusPresenter implements EntitySyncStatusPresenterInterface
{
    public function format(bool $status, array $meta = []): array
    {
        return [
            'links' => [
                'sync' => route('api.super-categories.sync', $meta['lastSync']),
            ],
            'data' => [
                'status' => $status,
            ],
        ];
    }
}
