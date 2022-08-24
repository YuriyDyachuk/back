<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Components\EntitiesSynchronizer\EntitiesSynchronizerFactory;
use App\Components\EntitiesSynchronizer\Presenters\EntitiesSyncStatusPresenterFactory;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Psr\Synchronizer\Contracts\Presenters\SyncStatusesPresenterFactoryInterface;
use Psr\Synchronizer\Contracts\Presenters\SyncStatusesPresenterInterface;
use Psr\Synchronizer\Contracts\SynchronizerFactoryInterface;
use Psr\Synchronizer\Contracts\SynchronizerInterface;

class EntitiesSyncController extends Controller
{
    private SynchronizerInterface $synchronizer;

    private SyncStatusesPresenterInterface $statusesPresenter;

    /**
     * EntitiesSyncController constructor.
     *
     * @param EntitiesSynchronizerFactory|SynchronizerFactoryInterface $synchronizerFactory
     * @param EntitiesSyncStatusPresenterFactory|SyncStatusesPresenterFactoryInterface $statusPresenterFactory
     */
    public function __construct(
        EntitiesSynchronizerFactory $synchronizerFactory,
        EntitiesSyncStatusPresenterFactory $statusPresenterFactory
    ) {
        $this->synchronizer = $synchronizerFactory->makeSynchronizer();
        $this->statusesPresenter = $statusPresenterFactory->make();
    }

    public function status(int $lastSync): JsonResponse
    {
        $statuses = $this->synchronizer->getStatues($lastSync);

        $formatted = $this->statusesPresenter->format($statuses, compact(
            'lastSync',
        ));

        return response()->json($formatted);
    }
}
