<?php
declare(strict_types=1);

namespace App\Components\Article\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityIndexPresenterFactoryInterface;
use App\Components\Entity\Contracts\Presenters\EntityIndexPresenterInterface;
use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;
use App\Components\Entity\Presenters\EntityIndexPresenter;

class ArticleIndexPresenterFactory implements EntityIndexPresenterFactoryInterface
{
    private EntityPresenterInterface $presenter;

    public function __construct(ArticlePresenter $articlePresenter)
    {
        $this->presenter = $articlePresenter;
    }

    public function make(): EntityIndexPresenterInterface
    {
        return new EntityIndexPresenter(
            $this->presenter
        );
    }
}
