<?php
declare(strict_types=1);

namespace App\Components\Admin\Category;

use App\Components\Admin\Category\DbGateways\CategoryCascadeDeletionDbGateway;
use App\Components\Admin\Document\DocumentPluralCascadeDeletionFactory;
use App\Components\Admin\Entity\Contracts\DbGateways\EntityCascadeDeletionDbGatewayInterface;
use App\Components\Admin\Entity\Contracts\EntityCascadeDeletionFactoryInterface;
use App\Components\Admin\Entity\Contracts\EntityCascadeDeletionInterface;
use App\Components\Admin\Entity\Contracts\EntityPluralCascadeDeletionFactoryInterface;

class CategoryCascadeDeletionFactory implements EntityCascadeDeletionFactoryInterface
{
    private EntityCascadeDeletionDbGatewayInterface $cascadeDeletionDbGateway;

    private EntityPluralCascadeDeletionFactoryInterface $entityCascadeDeletionFactory;

    public function __construct(
        CategoryCascadeDeletionDbGateway $categoryCascadeDeletionDbGateway,
        DocumentPluralCascadeDeletionFactory $entityPluralCascadeDeletionFactory
    ) {
        $this->cascadeDeletionDbGateway = $categoryCascadeDeletionDbGateway;
        $this->entityCascadeDeletionFactory = $entityPluralCascadeDeletionFactory;
    }

    public function make(): EntityCascadeDeletionInterface
    {
        return new CategoryCascadeDeletionService(
            $this->cascadeDeletionDbGateway,
            $this->entityCascadeDeletionFactory->make()
        );
    }
}
