<?php
declare(strict_types=1);

namespace App\Components\Admin\DocumentScraper;

use Psr\Scraper\Contracts\ScraperFactoryInterface;
use Psr\Scraper\Contracts\ScraperInterface;
use Psr\Scraper\ScraperFactory;

class DocumentScraperFactory implements ScraperFactoryInterface
{
    private ScraperFactoryInterface $scraperFactory;

    public function __construct(HtmlFetcher $fetcher)
    {
        $parser = new DocumentHtmlParser($fetcher);
        $this->scraperFactory = new ScraperFactory($fetcher, $parser);
    }

    public function makeScraper(): ScraperInterface
    {
        return $this->scraperFactory->makeScraper();
    }
}
