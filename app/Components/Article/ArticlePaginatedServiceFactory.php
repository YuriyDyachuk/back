<?php
declare(strict_types=1);

namespace App\Components\Article;

use App\Components\Article\DbGateways\ArticlePaginatedDbGateway;
use App\Components\Entity\Contracts\DbGateways\EntityPaginatedDbGatewayInterface;
use App\Components\Entity\Contracts\EntityPaginatedFactoryInterface;
use App\Components\Entity\Contracts\EntityPaginatedInterface;
use App\Components\Entity\EntityPaginatedService;

class ArticlePaginatedServiceFactory implements EntityPaginatedFactoryInterface
{
    private EntityPaginatedDbGatewayInterface $entityDbGateway;

    public function __construct(ArticlePaginatedDbGateway $entityDbGateway)
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
