<?php
declare(strict_types=1);

namespace App\Components\SuperCategory\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;
use App\Components\Entity\Contracts\Presenters\EntityShowPresenterFactoryInterface;
use App\Components\Entity\Contracts\Presenters\EntityShowPresenterInterface;
use App\Components\Entity\Presenters\EntityShowPresenter;

class SuperCategoryShowPresenterFactory implements EntityShowPresenterFactoryInterface
{
    private EntityPresenterInterface $presenter;

    public function __construct(SuperCategoryPresenter $superCategoryPresenter)
    {
        $this->presenter = $superCategoryPresenter;
    }

    public function make(): EntityShowPresenterInterface
    {
        return new EntityShowPresenter(
            $this->presenter
        );
    }
}
