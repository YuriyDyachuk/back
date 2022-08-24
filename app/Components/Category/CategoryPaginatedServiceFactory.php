<?php
declare(strict_types=1);

namespace App\Components\Category;

use App\Components\Category\DbGateways\CategoryPaginatedDbGateway;
use App\Components\Entity\Contracts\DbGateways\EntityPaginatedDbGatewayInterface;
use App\Components\Entity\Contracts\EntityPaginatedFactoryInterface;
use App\Components\Entity\Contracts\EntityPaginatedInterface;
use App\Components\Entity\EntityPaginatedService;

class CategoryPaginatedServiceFactory implements EntityPaginatedFactoryInterface
{
    private EntityPaginatedDbGatewayInterface $entityDbGateway;

    public function __construct(CategoryPaginatedDbGateway $entityDbGateway)
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
