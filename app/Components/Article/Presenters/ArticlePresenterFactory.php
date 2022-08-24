<?php
declare(strict_types=1);

namespace App\Components\Article\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityPresenterFactoryInterface;
use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;

class ArticlePresenterFactory implements EntityPresenterFactoryInterface
{
    private EntityPresenterInterface $presenter;

    public function __construct(ArticlePresenter $articlePresenter)
    {
        $this->presenter = $articlePresenter;
    }

    public function make(): EntityPresenterInterface
    {
        return $this->presenter;
    }
}
