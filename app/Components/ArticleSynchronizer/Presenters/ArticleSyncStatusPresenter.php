<?php
declare(strict_types=1);

namespace App\Components\ArticleSynchronizer\Presenters;

use App\Components\EntitiesSynchronizer\Contracts\Presenters\EntitySyncStatusPresenterInterface;

class ArticleSyncStatusPresenter implements EntitySyncStatusPresenterInterface
{
    public function format(bool $status, array $meta = []): array
    {
        return [
            'links' => [
                'sync' => route('api.articles.sync', $meta['lastSync']),
            ],
            'data' => [
                'status' => $status,
            ],
        ];
    }
}
