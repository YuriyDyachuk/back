<?php
declare(strict_types=1);

namespace App\Http\Controllers\AdminApi;

use App\Components\Admin\Document\DocumentCudFactory;
use App\Components\Admin\Entity\Contracts\EntityCudFactoryInterface;
use App\Components\Admin\Entity\Contracts\EntityCudInterface;
use App\Components\Document\Presenters\DocumentShowPresenterFactory;
use App\Components\Entity\Contracts\Presenters\EntityShowPresenterFactoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Document\StoreRequest;
use App\Http\Requests\AdminApi\Document\UpdateRequest;
use App\Models\Documents\Document;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DocumentController extends Controller
{
    private EntityCudInterface $cudService;

    private EntityShowPresenterFactoryInterface $showPresenterFactory;

    /**
     * DocumentController constructor.
     *
     * @param DocumentCudFactory|EntityCudFactoryInterface $cudServiceFactory
     * @param DocumentShowPresenterFactory $showPresenterFactory
     */
    public function __construct(
        DocumentCudFactory $cudServiceFactory,
        DocumentShowPresenterFactory $showPresenterFactory
    ) {
        $this->cudService = $cudServiceFactory->make();
        $this->showPresenterFactory = $showPresenterFactory;
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $document = $this->cudService->makeStore(
            $request->validated()
        );

        $showPresenter = $this->showPresenterFactory->make();
        $formatted = $showPresenter->format($document);

        dd($showPresenter);
        return response()->json($formatted);
    }

    public function update(UpdateRequest $request, Document $document): JsonResponse
    {
        $document = $this->cudService->makeUpdate([
            'data' => $request->validated(),
            'entity' => $document,
        ]);

        $showPresenter = $this->showPresenterFactory->make();
        $formatted = $showPresenter->format($document);

        return response()->json($formatted);
    }

    public function destroy(Document $document): Response
    {
        $this->cudService->makeDelete($document);

        return response()->noContent();
    }
}
