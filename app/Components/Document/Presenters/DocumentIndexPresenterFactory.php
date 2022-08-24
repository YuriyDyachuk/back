<?php
declare(strict_types=1);

namespace App\Components\Document\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityIndexPresenterFactoryInterface;
use App\Components\Entity\Contracts\Presenters\EntityIndexPresenterInterface;
use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;
use App\Components\Entity\Presenters\EntityIndexPresenter;

class DocumentIndexPresenterFactory implements EntityIndexPresenterFactoryInterface
{
    private EntityPresenterInterface $presenter;

    public function __construct(DocumentPresenter $documentPresenter)
    {
        $this->presenter = $documentPresenter;
    }

    public function make(): EntityIndexPresenterInterface
    {
        return new EntityIndexPresenter(
            $this->presenter
        );
    }
}
