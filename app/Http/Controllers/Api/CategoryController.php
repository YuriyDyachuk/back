<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Components\Category\CategoryPaginatedServiceFactory;
use App\Components\Category\Presenters\CategoryIndexPresenterFactory;
use App\Components\Category\Presenters\CategoryShowPresenterFactory;
use App\Components\CategorySynchronizer\CategorySyncServiceFactory;
use App\Components\CategorySynchronizer\Presenters\CategorySyncUpdatesPresenterFactory;
use App\Components\Entity\Contracts\EntityPaginatedFactoryInterface;
use App\Components\Entity\Contracts\Presenters\EntityIndexPresenterFactoryInterface;
use App\Components\Entity\Contracts\Presenters\EntityShowPresenterFactoryInterface;
use App\Http\Controllers\Controller;
use App\Models\Categories\Category;
use Illuminate\Http\JsonResponse;
use Psr\Synchronizer\Contracts\Presenters\SyncUpdatesPresenterFactoryInterface;
use Psr\Synchronizer\Contracts\SynchronizableFactoryInterface;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    private EntityPaginatedFactoryInterface $paginatedServiceFactory;

    private EntityIndexPresenterFactoryInterface $indexPresenterFactory;

    private EntityShowPresenterFactoryInterface $showPresenterFactory;

    private SynchronizableFactoryInterface $syncServiceFactory;

    private SyncUpdatesPresenterFactoryInterface $syncPresenterFactory;

    public function __construct(
        CategoryPaginatedServiceFactory $paginatedServiceFactory,
        CategoryIndexPresenterFactory $indexPresenterFactory,
        CategoryShowPresenterFactory $showPresenterFactory,
        CategorySyncServiceFactory $syncServiceFactory,
        CategorySyncUpdatesPresenterFactory $syncPresenterFactory
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

    public function show(Category $category): JsonResponse
    {
        $showPresenter = $this->showPresenterFactory->make();
        $formatted = $showPresenter->format($category);

        return response()->json($formatted);
    }

    public function sync(int $lastSync): JsonResponse
    {
        $user = Auth::user();
        $syncService = $this->syncServiceFactory->makeSynchronizable();
        $updates = $syncService->synchronize($lastSync, ['user_role' => $user->role_id]);

        $syncPresenter = $this->syncPresenterFactory->make();
        $formatted = $syncPresenter->format($updates);

        return response()->json($formatted);
    }
}
