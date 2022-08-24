<?php
declare(strict_types=1);

namespace App\Components\Entity\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;
use App\Components\Entity\Contracts\Presenters\EntityShowPresenterInterface;

class EntityShowPresenter implements EntityShowPresenterInterface
{
    private EntityPresenterInterface $entityPresenter;

    public function __construct(EntityPresenterInterface $entityPresenter)
    {
        $this->entityPresenter = $entityPresenter;
    }

    /**
     * @inheritDoc
     */
    public function format($entity): array
    {
        return [
            'data' => $this->entityPresenter->format($entity),
        ];
    }
}
