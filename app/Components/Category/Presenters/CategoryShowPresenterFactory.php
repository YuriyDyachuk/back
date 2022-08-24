<?php
declare(strict_types=1);

namespace App\Components\Category\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;
use App\Components\Entity\Contracts\Presenters\EntityShowPresenterFactoryInterface;
use App\Components\Entity\Contracts\Presenters\EntityShowPresenterInterface;
use App\Components\Entity\Presenters\EntityShowPresenter;

class CategoryShowPresenterFactory implements EntityShowPresenterFactoryInterface
{
    private EntityPresenterInterface $presenter;

    public function __construct(CategoryPresenter $categoryPresenter)
    {
        $this->presenter = $categoryPresenter;
    }

    public function make(): EntityShowPresenterInterface
    {
        return new EntityShowPresenter(
            $this->presenter
        );
    }
}
