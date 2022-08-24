<?php
declare(strict_types=1);

namespace App\Http\Controllers\AdminApi;

use App\Components\Admin\Article\ArticleCudFactory;
use App\Components\Admin\Entity\Contracts\EntityCudFactoryInterface;
use App\Components\Admin\Entity\Contracts\EntityCudInterface;
use App\Components\Article\Presenters\ArticleShowPresenterFactory;
use App\Components\Entity\Contracts\Presenters\EntityShowPresenterFactoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Article\StoreRequest;
use App\Http\Requests\AdminApi\Article\UpdateRequest;
use App\Models\Documents\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ArticleController extends Controller
{
    private EntityCudInterface $cudService;

    private EntityShowPresenterFactoryInterface $showPresenterFactory;

    /**
     * ArticleController constructor.
     *
     * @param ArticleCudFactory|EntityCudFactoryInterface $cudServiceFactory
     * @param ArticleShowPresenterFactory $showPresenterFactory
     */
    public function __construct(
        ArticleCudFactory $cudServiceFactory,
        ArticleShowPresenterFactory $showPresenterFactory
    ) {
        $this->cudService = $cudServiceFactory->make();
        $this->showPresenterFactory = $showPresenterFactory;
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $article = $this->cudService->makeStore(
            $request->validated()
        );

        $showPresenter = $this->showPresenterFactory->make();
        $formatted = $showPresenter->format($article);

        return response()->json($formatted);
    }

    public function update(UpdateRequest $request, Article $article): JsonResponse
    {
        $article = $this->cudService->makeUpdate([
            'data' => $request->validated(),
            'entity' => $article,
        ]);

        $showPresenter = $this->showPresenterFactory->make();
        $formatted = $showPresenter->format($article);

        return response()->json($formatted);
    }

    public function destroy(Article $article): Response
    {
        $this->cudService->makeDelete($article);

        return response()->noContent();
    }
}
