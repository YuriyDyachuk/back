<?php
declare(strict_types=1);

namespace App\Components\DocumentSynchronizer\Presenters;

use App\Components\EntitiesSynchronizer\Contracts\Presenters\EntitySyncStatusPresenterInterface;

class DocumentSyncStatusPresenter implements EntitySyncStatusPresenterInterface
{
    public function format(bool $status, array $meta = []): array
    {
        return [
            'links' => [
                'sync' => route('api.documents.sync', $meta['lastSync']),
            ],
            'data' => [
                'status' => $status,
            ],
        ];
    }
}
