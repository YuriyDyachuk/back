<?php
declare(strict_types=1);

namespace App\Components\Entity\Contracts;

interface EntityPaginatedFactoryInterface
{
    public function make(): EntityPaginatedInterface;
}
