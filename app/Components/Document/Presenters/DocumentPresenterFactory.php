<?php
declare(strict_types=1);

namespace App\Components\Document\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityPresenterFactoryInterface;
use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;

class DocumentPresenterFactory implements EntityPresenterFactoryInterface
{
    private EntityPresenterInterface $presenter;

    public function __construct(DocumentPresenter $documentPresenter)
    {
        $this->presenter = $documentPresenter;
    }

    public function make(): EntityPresenterInterface
    {
        return $this->presenter;
    }
}
