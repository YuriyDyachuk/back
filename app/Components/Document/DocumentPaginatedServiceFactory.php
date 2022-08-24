<?php
declare(strict_types=1);

namespace App\Components\Document;

use App\Components\Document\DbGateways\DocumentPaginatedDbGateway;
use App\Components\Entity\Contracts\DbGateways\EntityPaginatedDbGatewayInterface;
use App\Components\Entity\Contracts\EntityPaginatedFactoryInterface;
use App\Components\Entity\Contracts\EntityPaginatedInterface;
use App\Components\Entity\EntityPaginatedService;

class DocumentPaginatedServiceFactory implements EntityPaginatedFactoryInterface
{
    private EntityPaginatedDbGatewayInterface $entityDbGateway;

    public function __construct(DocumentPaginatedDbGateway $entityDbGateway)
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
