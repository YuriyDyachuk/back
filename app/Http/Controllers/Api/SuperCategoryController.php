<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Components\Entity\Contracts\EntityPaginatedFactoryInterface;
use App\Components\Entity\Contracts\Presenters\EntityIndexPresenterFactoryInterface;
use App\Components\Entity\Contracts\Presenters\EntityShowPresenterFactoryInterface;
use App\Components\SuperCategory\Presenters\SuperCategoryIndexPresenterFactory;
use App\Components\SuperCategory\Presenters\SuperCategoryShowPresenterFactory;
use App\Components\SuperCategory\SuperCategoryPaginatedServiceFactory;
use App\Components\SuperCategorySynchronizer\Presenters\SuperCategorySyncUpdatesPresenterFactory;
use App\Components\SuperCategorySynchronizer\SuperCategorySyncServiceFactory;
use App\Http\Controllers\Controller;
use App\Models\Categories\SuperCategory;
use Illuminate\Http\JsonResponse;
use Psr\Synchronizer\Contracts\Presenters\SyncUpdatesPresenterFactoryInterface;
use Psr\Synchronizer\Contracts\SynchronizableFactoryInterface;
use Illuminate\Support\Facades\Auth;

class SuperCategoryController extends Controller
{
    private EntityPaginatedFactoryInterface $paginatedServiceFactory;

    private EntityIndexPresenterFactoryInterface $indexPresenterFactory;

    private EntityShowPresenterFactoryInterface $showPresenterFactory;

    private SynchronizableFactoryInterface $syncServiceFactory;

    private SyncUpdatesPresenterFactoryInterface $syncPresenterFactory;

    public function __construct(
        SuperCategoryPaginatedServiceFactory $paginatedServiceFactory,
        SuperCategoryIndexPresenterFactory $indexPresenterFactory,
        SuperCategoryShowPresenterFactory $showPresenterFactory,
        SuperCategorySyncServiceFactory $syncServiceFactory,
        SuperCategorySyncUpdatesPresenterFactory $syncPresenterFactory
    ) {
        $this->paginatedServiceFactory = $paginatedServiceFactory;
        $this->indexPresenterFactory = $indexPresenterFactory;
        $this->showPresenterFactory = $showPresenterFactory;
        $this->syncServiceFactory = $syncServiceFactory;
        $this->syncPresenterFactory = $syncPresenterFactory;
    }

    public function index(): JsonResponse
    {
        $paginatedService = $this->paginatedServiceFactory->make();
        $paginated = $paginatedService->getPaginated([]);

        $indexPresenter = $this->indexPresenterFactory->make();
        $formatted = $indexPresenter->format($paginated);

        return response()->json($formatted);
    }

    public function show(SuperCategory $superCategory): JsonResponse
    {
        $showPresenter = $this->showPresenterFactory->make();
        $formatted = $showPresenter->format($superCategory);

        return response()->json($formatted);
    }

    public function sync(int $lastSync): JsonResponse
    {
        $user = Auth::user();
        $syncService = $this->syncServiceFactory->makeSynchronizable();
        $updates = $syncService->synchronize($lastSync,['user_role' => $user->role_id]);

        $syncPresenter = $this->syncPresenterFactory->make();
        $formatted = $syncPresenter->format($updates);

        return response()->json($formatted);
    }
}
