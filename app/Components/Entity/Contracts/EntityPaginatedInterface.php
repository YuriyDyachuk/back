<?php
declare(strict_types=1);

namespace App\Components\Entity\Contracts;

interface EntityPaginatedInterface
{
    public function getPaginated(array $options): array;
}
