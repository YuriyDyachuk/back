<?php
declare(strict_types=1);

namespace Psr\Scraper\Contracts;

interface ScraperInterface
{
    public function handle(string $resourceLocator): array;
}
