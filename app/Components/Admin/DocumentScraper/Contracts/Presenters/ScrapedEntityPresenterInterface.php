<?php
declare(strict_types=1);

namespace App\Components\Admin\DocumentScraper\Contracts\Presenters;

interface ScrapedEntityPresenterInterface
{
    public function format(array $scrapedEntity): array;
}
