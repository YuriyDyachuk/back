<?php
declare(strict_types=1);

namespace Psr\Scraper\Contracts;

interface ScraperFactoryInterface
{
    public function makeScraper(): ScraperInterface;
}
