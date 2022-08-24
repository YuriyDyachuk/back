<?php
declare(strict_types=1);

namespace App\Components\Admin\Section;

use App\Components\Admin\Article\ArticleCascadeDeletionFactory;
use App\Components\Admin\Entity\Contracts\DbGateways\EntityCudDbGatewayInterface;
use App\Components\Admin\Entity\Contracts\EntityCascadeDeletionFactoryInterface;
use App\Components\Admin\Entity\Contracts\EntityCudFactoryInterface;
use App\Components\Admin\Entity\Contracts\EntityCudInterface;
use App\Components\Admin\Section\DbGateways\SectionCudDbGateway;

class SectionCudFactory implements EntityCudFactoryInterface
{
    private EntityCudDbGatewayInterface $entityCudDbGateway;

    private EntityCascadeDeletionFactoryInterface $entityCascadeDeletionFactory;

    public function __construct(
        SectionCudDbGateway $entityCudDbGateway,
        ArticleCascadeDeletionFactory $entityCascadeDeletionFactory
    ) {
        $this->entityCudDbGateway = $entityCudDbGateway;
        $this->entityCascadeDeletionFactory = $entityCascadeDeletionFactory;
    }

    public function make(): EntityCudInterface
    {
        return new SectionCudService(
            $this->entityCudDbGateway,
            $this->entityCascadeDeletionFactory->make()
        );
    }
}
