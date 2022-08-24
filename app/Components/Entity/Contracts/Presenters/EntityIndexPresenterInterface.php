<?php
declare(strict_types=1);

namespace App\Components\Entity\Contracts\Presenters;

interface EntityIndexPresenterInterface
{
    public function format(array $entities);
}
