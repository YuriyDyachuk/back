<?php
declare(strict_types=1);

namespace App\Components\SectionSynchronizer\Presenters;

use App\Components\EntitiesSynchronizer\Contracts\Presenters\EntitySyncStatusPresenterInterface;

class SectionSyncStatusPresenter implements EntitySyncStatusPresenterInterface
{
    public function format(bool $status, array $meta = []): array
    {
        return [
            'links' => [
                'sync' => route('api.sections.sync', $meta['lastSync']),
            ],
            'data' => [
                'status' => $status,
            ],
        ];
    }
}
