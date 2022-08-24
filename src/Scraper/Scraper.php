<?php
declare(strict_types=1);

namespace Psr\Scraper;

use Psr\Scraper\Contracts\ResourceFetcherInterface;
use Psr\Scraper\Contracts\ResourceParserInterface;

class Scraper implements Contracts\ScraperInterface
{
    private ResourceFetcherInterface $fetcher;

    private ResourceParserInterface $parser;

    public function __construct(ResourceFetcherInterface $fetcher, ResourceParserInterface $parser)
    {
        $this->fetcher = $fetcher;
        $this->parser = $parser;
    }

    public function handle(string $resourceLocator): array
    {
        $content = $this->fetcher->fetch($resourceLocator);

        return $this->parser->parse([
            'content' => $content,
            'resource' => $resourceLocator,
        ]);
    }
}
