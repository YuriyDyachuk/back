<?php
declare(strict_types=1);

namespace App\Http\Controllers\AdminApi;

use App\Components\Admin\Category\CategoryCudFactory;
use App\Components\Admin\Entity\Contracts\EntityCudFactoryInterface;
use App\Components\Admin\Entity\Contracts\EntityCudInterface;
use App\Components\Category\Presenters\CategoryShowPresenterFactory;
use App\Components\Entity\Contracts\Presenters\EntityShowPresenterFactoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Category\StoreRequest;
use App\Http\Requests\AdminApi\Category\UpdateRequest;
use App\Models\Categories\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    private EntityCudInterface $cudService;

    private EntityShowPresenterFactoryInterface $showPresenterFactory;

    /**
     * CategoryController constructor.
     *
     * @param CategoryCudFactory|EntityCudFactoryInterface $cudServiceFactory
     * @param CategoryShowPresenterFactory $showPresenterFactory
     */
    public function __construct(
        CategoryCudFactory $cudServiceFactory,
        CategoryShowPresenterFactory $showPresenterFactory
    ) {
        $this->cudService = $cudServiceFactory->make();
        $this->showPresenterFactory = $showPresenterFactory;
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $category = $this->cudService->makeStore(
            $request->validated()
        );

        $showPresenter = $this->showPresenterFactory->make();
        $formatted = $showPresenter->format($category);

        return response()->json($formatted);
    }

    public function update(UpdateRequest $request, Category $category): JsonResponse
    {
        $category = $this->cudService->makeUpdate([
            'data' => $request->validated(),
            'entity' => $category,
        ]);

        $showPresenter = $this->showPresenterFactory->make();
        $formatted = $showPresenter->format($category);

        return response()->json($formatted);
    }

    public function destroy(Category $category): Response
    {
        $this->cudService->makeDelete($category);

        return response()->noContent();
    }
}
