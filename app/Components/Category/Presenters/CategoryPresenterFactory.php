<?php
declare(strict_types=1);

namespace App\Components\Category\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityPresenterFactoryInterface;
use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;

class CategoryPresenterFactory implements EntityPresenterFactoryInterface
{
    private EntityPresenterInterface $presenter;

    public function __construct(CategoryPresenter $categoryPresenter)
    {
        $this->presenter = $categoryPresenter;
    }

    public function make(): EntityPresenterInterface
    {
        return $this->presenter;
    }
}
