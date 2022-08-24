<?php
declare(strict_types=1);

namespace Psr\Scraper;

use Psr\Scraper\Contracts\ResourceFetcherInterface;
use Psr\Scraper\Contracts\ResourceParserInterface;
use Psr\Scraper\Contracts\ScraperInterface;

class ScraperFactory implements Contracts\ScraperFactoryInterface
{
    private ResourceFetcherInterface $fetcher;

    private ResourceParserInterface $parser;

    public function __construct(ResourceFetcherInterface $fetcher, ResourceParserInterface $parser)
    {
        $this->fetcher = $fetcher;
        $this->parser = $parser;
    }

    public function makeScraper(): ScraperInterface
    {
        return new Scraper($this->fetcher, $this->parser);
    }
}
