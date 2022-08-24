<?php
declare(strict_types=1);

namespace App\Components\Admin\DocumentScraper\Contracts\Presenters;

interface ScrapedEntityPresenterFactoryInterface
{
    public function make(): ScrapedEntityPresenterInterface;
}
