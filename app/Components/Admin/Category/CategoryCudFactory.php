<?php
declare(strict_types=1);

namespace App\Components\Admin\Category;

use App\Components\Admin\Category\DbGateways\CategoryCudDbGateway;
use App\Components\Admin\Document\DocumentCascadeDeletionFactory;
use App\Components\Admin\Entity\Contracts\DbGateways\EntityCudDbGatewayInterface;
use App\Components\Admin\Entity\Contracts\EntityCascadeDeletionFactoryInterface;
use App\Components\Admin\Entity\Contracts\EntityCudFactoryInterface;
use App\Components\Admin\Entity\Contracts\EntityCudInterface;

class CategoryCudFactory implements EntityCudFactoryInterface
{
    private EntityCudDbGatewayInterface $entityCudDbGateway;

    private EntityCascadeDeletionFactoryInterface $entityCascadeDeletionFactory;

    public function __construct(
        CategoryCudDbGateway $entityCudDbGateway,
        DocumentCascadeDeletionFactory $entityCascadeDeletionFactory
    ) {
        $this->entityCudDbGateway = $entityCudDbGateway;
        $this->entityCascadeDeletionFactory = $entityCascadeDeletionFactory;
    }

    public function make(): EntityCudInterface
    {
        return new CategoryCudService(
            $this->entityCudDbGateway,
            $this->entityCascadeDeletionFactory->make()
        );
    }
}
