<?php
declare(strict_types=1);

namespace App\Components\Entity\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityIndexPresenterInterface;
use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;

class EntityIndexPresenter implements EntityIndexPresenterInterface
{
    use PaginatedEntityFormatterTrait;

    private EntityPresenterInterface $entityPresenter;

    public function __construct(EntityPresenterInterface $entityPresenter)
    {
        $this->entityPresenter = $entityPresenter;
    }

    public function format(array $entities)
    {
        return $this->formatPaginated($entities);
    }

    protected function getEntityPresenter(): EntityPresenterInterface
    {
        return $this->entityPresenter;
    }
}
