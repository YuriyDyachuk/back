<?php
declare(strict_types=1);

namespace App\Components\Entity;

use App\Components\Entity\Contracts\DbGateways\EntityPaginatedDbGatewayInterface;

class EntityPaginatedService implements Contracts\EntityPaginatedInterface
{
    private EntityPaginatedDbGatewayInterface $entityDbGateway;

    public function __construct(EntityPaginatedDbGatewayInterface $entityDbGateway)
    {
        $this->entityDbGateway = $entityDbGateway;
    }

    public function getPaginated(array $options = []): array
    {
        return $this->entityDbGateway->getPaginated($options);
    }
}
