<?php
declare(strict_types=1);

namespace Psr\Scraper\Contracts;

interface ResourceFetcherInterface
{
    public function fetch(string $resourceLocator): string;
}
