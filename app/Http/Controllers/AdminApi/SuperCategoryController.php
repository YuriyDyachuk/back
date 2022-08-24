<?php
declare(strict_types=1);

namespace App\Http\Controllers\AdminApi;

use App\Components\Admin\Entity\Contracts\EntityCudFactoryInterface;
use App\Components\Admin\Entity\Contracts\EntityCudInterface;
use App\Components\Admin\SuperCategory\SuperCategoryCudFactory;
use App\Components\Entity\Contracts\Presenters\EntityShowPresenterFactoryInterface;
use App\Components\SuperCategory\Presenters\SuperCategoryShowPresenterFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\SuperCategory\StoreRequest;
use App\Http\Requests\AdminApi\SuperCategory\UpdateRequest;
use App\Models\Categories\SuperCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SuperCategoryController extends Controller
{
    private EntityCudInterface $cudService;

    private EntityShowPresenterFactoryInterface $showPresenterFactory;

    /**
     * SuperCategoryController constructor.
     *
     * @param SuperCategoryCudFactory|EntityCudFactoryInterface $cudServiceFactory
     * @param SuperCategoryShowPresenterFactory $showPresenterFactory
     */
    public function __construct(
        SuperCategoryCudFactory $cudServiceFactory,
        SuperCategoryShowPresenterFactory $showPresenterFactory
    ) {
        $this->cudService = $cudServiceFactory->make();
        $this->showPresenterFactory = $showPresenterFactory;
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $superCategory = $this->cudService->makeStore(
            $request->validated()
        );

        $showPresenter = $this->showPresenterFactory->make();
        $formatted = $showPresenter->format($superCategory);

        return response()->json($formatted);
    }

    public function update(UpdateRequest $request, SuperCategory $superCategory): JsonResponse
    {
        $superCategory = $this->cudService->makeUpdate([
            'data' => $request->validated(),
            'entity' => $superCategory,
        ]);

        $showPresenter = $this->showPresenterFactory->make();
        $formatted = $showPresenter->format($superCategory);

        return response()->json($formatted);
    }

    public function destroy(SuperCategory $superCategory): Response
    {
        $this->cudService->makeDelete($superCategory);

        return response()->noContent();
    }
}
