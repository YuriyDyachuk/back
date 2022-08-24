<?php
declare(strict_types=1);

namespace App\Components\Admin\DocumentScraper\Presenters;

use App\Components\Admin\DocumentScraper\Contracts\Presenters\ScrapedEntityPresenterFactoryInterface;
use App\Components\Admin\DocumentScraper\Contracts\Presenters\ScrapedEntityPresenterInterface;

class ParsedDocumentPresenterFactory implements ScrapedEntityPresenterFactoryInterface
{
    private ScrapedEntityPresenterInterface $scrapedEntity;

    public function __construct(ParsedDocumentPresenter $scrapedEntity)
    {
        $this->scrapedEntity = $scrapedEntity;
    }

    public function make(): ScrapedEntityPresenterInterface
    {
        return $this->scrapedEntity;
    }
}
