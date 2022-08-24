<?php
declare(strict_types=1);

namespace App\Components\Entity\Contracts\DbGateways;

interface EntityPaginatedDbGatewayInterface
{
    public function getPaginated(array $options): array;
}
