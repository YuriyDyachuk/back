<?php
declare(strict_types=1);

namespace App\Components\Entity\Contracts\Presenters;

interface EntityPresenterFactoryInterface
{
    public function make(): EntityPresenterInterface;
}
