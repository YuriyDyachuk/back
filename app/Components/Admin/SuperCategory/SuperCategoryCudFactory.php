<?php
declare(strict_types=1);

namespace App\Components\Admin\SuperCategory;

use App\Components\Admin\Category\CategoryCascadeDeletionFactory;
use App\Components\Admin\Entity\Contracts\DbGateways\EntityCudDbGatewayInterface;
use App\Components\Admin\Entity\Contracts\EntityCascadeDeletionFactoryInterface;
use App\Components\Admin\Entity\Contracts\EntityCudFactoryInterface;
use App\Components\Admin\Entity\Contracts\EntityCudInterface;
use App\Components\Admin\SuperCategory\DbGateways\SuperCategoryCudDbGateway;

class SuperCategoryCudFactory implements EntityCudFactoryInterface
{
    private EntityCudDbGatewayInterface $entityCudDbGateway;

    private EntityCascadeDeletionFactoryInterface $entityCascadeDeletionFactory;

    public function __construct(
        SuperCategoryCudDbGateway $entityCudDbGateway,
        CategoryCascadeDeletionFactory $entityCascadeDeletionFactory
    ) {
        $this->entityCudDbGateway = $entityCudDbGateway;
        $this->entityCascadeDeletionFactory = $entityCascadeDeletionFactory;
    }

    public function make(): EntityCudInterface
    {
        return new SuperCategoryCudService(
            $this->entityCudDbGateway,
            $this->entityCascadeDeletionFactory->make()
        );
    }
}
