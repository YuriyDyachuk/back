<?php
declare(strict_types=1);

namespace App\Components\SuperCategory\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityPresenterFactoryInterface;
use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;

class SuperCategoryPresenterFactory implements EntityPresenterFactoryInterface
{
    private EntityPresenterInterface $presenter;

    public function __construct(SuperCategoryPresenter $superCategoryPresenter)
    {
        $this->presenter = $superCategoryPresenter;
    }

    public function make(): EntityPresenterInterface
    {
        return $this->presenter;
    }
}
