<?php
declare(strict_types=1);

namespace App\Components\Admin\Document;

use App\Components\Admin\Document\DbGateways\DocumentCudDbGateway;
use App\Components\Admin\Entity\Contracts\DbGateways\EntityCudDbGatewayInterface;
use App\Components\Admin\Entity\Contracts\EntityCascadeDeletionFactoryInterface;
use App\Components\Admin\Entity\Contracts\EntityCudFactoryInterface;
use App\Components\Admin\Entity\Contracts\EntityCudInterface;
use App\Components\Admin\Section\SectionCascadeDeletionFactory;

class DocumentCudFactory implements EntityCudFactoryInterface
{
    private EntityCudDbGatewayInterface $entityCudDbGateway;

    private EntityCascadeDeletionFactoryInterface $entityCascadeDeletionFactory;

    public function __construct(
        DocumentCudDbGateway $entityCudDbGateway,
        SectionCascadeDeletionFactory $entityCascadeDeletionFactory
    ) {
        $this->entityCudDbGateway = $entityCudDbGateway;
        $this->entityCascadeDeletionFactory = $entityCascadeDeletionFactory;
    }

    public function make(): EntityCudInterface
    {
        return new DocumentCudService(
            $this->entityCudDbGateway,
            $this->entityCascadeDeletionFactory->make()
        );
    }
}
