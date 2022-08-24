<?php
declare(strict_types=1);

namespace App\Components\Document\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;
use App\Components\Entity\Contracts\Presenters\EntityShowPresenterFactoryInterface;
use App\Components\Entity\Contracts\Presenters\EntityShowPresenterInterface;
use App\Components\Entity\Presenters\EntityShowPresenter;

class DocumentShowPresenterFactory implements EntityShowPresenterFactoryInterface
{
    private EntityPresenterInterface $presenter;

    public function __construct(DocumentPresenter $documentPresenter)
    {
        $this->presenter = $documentPresenter;
    }

    public function make(): EntityShowPresenterInterface
    {
        return new EntityShowPresenter(
            $this->presenter
        );
    }
}
