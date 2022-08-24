<?php
declare(strict_types=1);

namespace App\Components\Section\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityPresenterFactoryInterface;
use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;

class SectionPresenterFactory implements EntityPresenterFactoryInterface
{
    private EntityPresenterInterface $presenter;

    public function __construct(SectionPresenter $sectionPresenter)
    {
        $this->presenter = $sectionPresenter;
    }

    public function make(): EntityPresenterInterface
    {
        return $this->presenter;
    }
}
