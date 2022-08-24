<?php
declare(strict_types=1);

namespace App\Components\User\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;
use App\Components\Entity\Contracts\Presenters\EntityShowPresenterFactoryInterface;
use App\Components\Entity\Contracts\Presenters\EntityShowPresenterInterface;
use App\Components\Entity\Presenters\EntityShowPresenter;

/**
 * Class UserShowPresenterFactory
 * @package App\Components\User\Presenters
 */
class UserShowPresenterFactory implements EntityShowPresenterFactoryInterface
{
    private EntityPresenterInterface $presenter;

    /**
     * UserShowPresenterFactory constructor.
     * @param UserPresenter $userPresenter
     */
    public function __construct(UserPresenter $userPresenter)
    {
        $this->presenter = $userPresenter;
    }

    /**
     * @return EntityShowPresenterInterface
     */
    public function make(): EntityShowPresenterInterface
    {
        return new EntityShowPresenter(
            $this->presenter
        );
    }
}
