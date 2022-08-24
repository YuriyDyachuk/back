<?php
declare(strict_types=1);

namespace App\Components\Entity\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;

trait PaginatedEntityFormatterTrait
{
    abstract protected function getEntityPresenter(): EntityPresenterInterface;

    protected function formatPaginated(array $paginatedEntity): array
    {
        $formatted['data'] = array_map(function ($entity) {
            return $this->getEntityPresenter()->format($entity);
        }, $paginatedEntity['data']);

        $formatted['links'] = [
            'next' => $paginatedEntity['next_page_url'],
        ];
        $formatted['meta'] = [
            'current_page' => $paginatedEntity['current_page'],
            'from' => $paginatedEntity['from'],
            'to' => $paginatedEntity['to'],
            'per_page' => $paginatedEntity['per_page'],
        ];

        return $formatted;
    }
}
