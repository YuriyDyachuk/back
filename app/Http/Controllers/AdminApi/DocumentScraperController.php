<?php
declare(strict_types=1);

namespace App\Http\Controllers\AdminApi;

use App\Components\Admin\DocumentScraper\Contracts\Presenters\ScrapedEntityPresenterFactoryInterface;
use App\Components\Admin\DocumentScraper\Contracts\Presenters\ScrapedEntityPresenterInterface;
use App\Components\Admin\DocumentScraper\DocumentScraperFactory;
use App\Components\Admin\DocumentScraper\Presenters\ParsedDocumentPresenterFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\DocumentScraper\ScrapRequest;
use Illuminate\Http\JsonResponse;
use Psr\Scraper\Contracts\ScraperFactoryInterface;
use Psr\Scraper\Contracts\ScraperInterface;

use App\Services\DocumentSaver\DocumentSaverManager;

class DocumentScraperController extends Controller
{
    private ScraperInterface $scraperService;

    private ScrapedEntityPresenterInterface $scraperPresenter;


    /**
     * DocumentScraperController constructor.
     *
     * @param DocumentScraperFactory|ScraperFactoryInterface $scraperServiceFactory
     * @param ParsedDocumentPresenterFactory|ScrapedEntityPresenterFactoryInterface $scraperPresenterFactory
     */
    public function __construct(
        DocumentScraperFactory $scraperServiceFactory,
        ParsedDocumentPresenterFactory $scraperPresenterFactory
    ) {
        $this->scraperService = $scraperServiceFactory->makeScraper();
        $this->scraperPresenter = $scraperPresenterFactory->make();
    }

    public function scrap(ScrapRequest $request)
    {

        $document = $this->scraperService->handle(
            $request->getResourceLocator()
        );
        $formatted = $this->scraperPresenter->format($document);
        //documentSaverManager::store($formatted, $request->documentUrl);

        if (documentSaverManager::store($formatted, $request->documentUrl, $request->categoryId)) {
            return response()->json(true);
        }
        return response()->json(false);
        return response()->json($formatted);
    }

    public function scrapAdmin($id, $url): JsonResponse
    {
        dd($url);
        $document = $this->scraperService->handle($url);

        $formatted = $this->scraperPresenter->format($document);

        return response()->json($formatted);
    }
}
