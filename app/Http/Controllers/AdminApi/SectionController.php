<?php
declare(strict_types=1);

namespace App\Http\Controllers\AdminApi;

use App\Components\Admin\Entity\Contracts\EntityCudFactoryInterface;
use App\Components\Admin\Entity\Contracts\EntityCudInterface;
use App\Components\Admin\Section\SectionCudFactory;
use App\Components\Entity\Contracts\Presenters\EntityShowPresenterFactoryInterface;
use App\Components\Section\Presenters\SectionShowPresenterFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Section\StoreRequest;
use App\Http\Requests\AdminApi\Section\UpdateRequest;
use App\Models\Documents\Section;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SectionController extends Controller
{
    private EntityCudInterface $cudService;

    private EntityShowPresenterFactoryInterface $showPresenterFactory;

    /**
     * SectionController constructor.
     *
     * @param SectionCudFactory|EntityCudFactoryInterface $cudServiceFactory
     * @param SectionShowPresenterFactory $showPresenterFactory
     */
    public function __construct(
        SectionCudFactory $cudServiceFactory,
        SectionShowPresenterFactory $showPresenterFactory
    ) {
        $this->cudService = $cudServiceFactory->make();
        $this->showPresenterFactory = $showPresenterFactory;
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $section = $this->cudService->makeStore(
            $request->validated()
        );

        $showPresenter = $this->showPresenterFactory->make();
        $formatted = $showPresenter->format($section);

        return response()->json($formatted);
    }

    public function update(UpdateRequest $request, Section $section): JsonResponse
    {
        $section = $this->cudService->makeUpdate([
            'data' => $request->validated(),
            'entity' => $section,
        ]);

        $showPresenter = $this->showPresenterFactory->make();
        $formatted = $showPresenter->format($section);

        return response()->json($formatted);
    }

    public function destroy(Section $section): Response
    {
        $this->cudService->makeDelete($section);

        return response()->noContent();
    }
}
