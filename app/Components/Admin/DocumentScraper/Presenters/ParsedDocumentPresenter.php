<?php
declare(strict_types=1);

namespace App\Components\Admin\DocumentScraper\Presenters;

use App\Components\Admin\DocumentScraper\Contracts\Presenters\ScrapedEntityPresenterInterface;

class ParsedDocumentPresenter implements ScrapedEntityPresenterInterface
{
    public function format(array $parsedDocument): array
    {
        return [
            'data' => $parsedDocument,
        ];
    }
}
