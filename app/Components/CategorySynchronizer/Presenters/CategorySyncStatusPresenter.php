<?php
declare(strict_types=1);

namespace App\Components\CategorySynchronizer\Presenters;

use App\Components\EntitiesSynchronizer\Contracts\Presenters\EntitySyncStatusPresenterInterface;

class CategorySyncStatusPresenter implements EntitySyncStatusPresenterInterface
{
    public function format(bool $status, array $meta = []): array
    {
        return [
            'links' => [
                'sync' => route('api.categories.sync', $meta['lastSync']),
            ],
            'data' => [
                'status' => $status,
            ],
        ];
    }
}
