<?php
declare(strict_types=1);

namespace App\Components\SuperCategory\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityIndexPresenterFactoryInterface;
use App\Components\Entity\Contracts\Presenters\EntityIndexPresenterInterface;
use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;
use App\Components\Entity\Presenters\EntityIndexPresenter;

class SuperCategoryIndexPresenterFactory implements EntityIndexPresenterFactoryInterface
{
    private EntityPresenterInterface $presenter;

    public function __construct(SuperCategoryPresenter $superCategoryPresenter)
    {
        $this->presenter = $superCategoryPresenter;
    }

    public function make(): EntityIndexPresenterInterface
    {
        return new EntityIndexPresenter(
            $this->presenter
        );
    }
}
