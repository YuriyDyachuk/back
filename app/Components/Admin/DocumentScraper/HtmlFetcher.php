<?php
declare(strict_types=1);

namespace App\Components\Admin\DocumentScraper;

use Illuminate\Support\Facades\Http;
use Psr\Scraper\Contracts\ResourceFetcherInterface;

class HtmlFetcher implements ResourceFetcherInterface
{
    public function fetch(string $resourceLocator): string
    {
        return Http::get($resourceLocator)
            ->body();
    }
}
