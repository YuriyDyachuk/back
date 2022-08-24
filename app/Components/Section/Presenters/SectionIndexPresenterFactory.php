<?php
declare(strict_types=1);

namespace App\Components\Section\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityIndexPresenterFactoryInterface;
use App\Components\Entity\Contracts\Presenters\EntityIndexPresenterInterface;
use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;
use App\Components\Entity\Presenters\EntityIndexPresenter;

class SectionIndexPresenterFactory implements EntityIndexPresenterFactoryInterface
{
    private EntityPresenterInterface $presenter;

    public function __construct(SectionPresenter $sectionPresenter)
    {
        $this->presenter = $sectionPresenter;
    }

    public function make(): EntityIndexPresenterInterface
    {
        return new EntityIndexPresenter(
            $this->presenter
        );
    }
}
