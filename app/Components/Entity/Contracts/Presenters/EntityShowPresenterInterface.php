<?php
declare(strict_types=1);

namespace App\Components\Entity\Contracts\Presenters;

use Illuminate\Database\Eloquent\Model;

interface EntityShowPresenterInterface
{
    /**
     * @param Model|object $entity
     *
     * @return array
     */
    public function format($entity): array;
}
