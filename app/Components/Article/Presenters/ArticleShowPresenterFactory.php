<?php
declare(strict_types=1);

namespace App\Components\Article\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;
use App\Components\Entity\Contracts\Presenters\EntityShowPresenterFactoryInterface;
use App\Components\Entity\Contracts\Presenters\EntityShowPresenterInterface;
use App\Components\Entity\Presenters\EntityShowPresenter;

class ArticleShowPresenterFactory implements EntityShowPresenterFactoryInterface
{
    private EntityPresenterInterface $presenter;

    public function __construct(ArticlePresenter $articlePresenter)
    {
        $this->presenter = $articlePresenter;
    }

    public function make(): EntityShowPresenterInterface
    {
        return new EntityShowPresenter(
            $this->presenter
        );
    }
}
