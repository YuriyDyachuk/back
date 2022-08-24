<?php
declare(strict_types=1);

namespace App\Components\Category\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityIndexPresenterFactoryInterface;
use App\Components\Entity\Contracts\Presenters\EntityIndexPresenterInterface;
use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;
use App\Components\Entity\Presenters\EntityIndexPresenter;

class CategoryIndexPresenterFactory implements EntityIndexPresenterFactoryInterface
{
    private EntityPresenterInterface $presenter;

    public function __construct(CategoryPresenter $categoryPresenter)
    {
        $this->presenter = $categoryPresenter;
    }

    public function make(): EntityIndexPresenterInterface
    {
        return new EntityIndexPresenter(
            $this->presenter
        );
    }
}
