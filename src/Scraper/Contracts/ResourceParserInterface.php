<?php
declare(strict_types=1);

namespace Psr\Scraper\Contracts;

interface ResourceParserInterface
{
    public function parse(array $resourceData): array;
}
