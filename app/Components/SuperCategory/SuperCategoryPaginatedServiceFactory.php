<?php
declare(strict_types=1);

namespace App\Components\SuperCategory;

use App\Components\Entity\Contracts\DbGateways\EntityPaginatedDbGatewayInterface;
use App\Components\Entity\Contracts\EntityPaginatedFactoryInterface;
use App\Components\Entity\Contracts\EntityPaginatedInterface;
use App\Components\Entity\EntityPaginatedService;
use App\Components\SuperCategory\DbGateways\SuperCategoryPaginatedDbGateway;

class SuperCategoryPaginatedServiceFactory implements EntityPaginatedFactoryInterface
{
    private EntityPaginatedDbGatewayInterface $entityDbGateway;

    public function __construct(SuperCategoryPaginatedDbGateway $entityDbGateway)
    {
        $this->entityDbGateway = $entityDbGateway;
    }

    public function make(): EntityPaginatedInterface
    {
        return new EntityPaginatedService(
            $this->entityDbGateway
        );
    }
}
