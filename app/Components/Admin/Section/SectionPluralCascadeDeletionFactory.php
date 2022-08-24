<?php
declare(strict_types=1);

namespace App\Components\Admin\Section;

use App\Components\Admin\Article\ArticlePluralCascadeDeletionFactory;
use App\Components\Admin\Entity\Contracts\DbGateways\EntityPluralCascadeDeletionDbGatewayInterface;
use App\Components\Admin\Entity\Contracts\EntityPluralCascadeDeletionFactoryInterface;
use App\Components\Admin\Entity\Contracts\EntityPluralCascadeDeletionInterface;
use App\Components\Admin\Section\DbGateways\SectionPluralCascadeDeletionDbGateway;

class SectionPluralCascadeDeletionFactory implements EntityPluralCascadeDeletionFactoryInterface
{
    private EntityPluralCascadeDeletionDbGatewayInterface $cascadeDeletionDbGateway;

    private EntityPluralCascadeDeletionFactoryInterface $entityCascadeDeletionFactory;

    public function __construct(
        SectionPluralCascadeDeletionDbGateway $sectionPluralCascadeDeletionDbGateway,
        ArticlePluralCascadeDeletionFactory $entityPluralCascadeDeletionFactory
    ) {
        $this->cascadeDeletionDbGateway = $sectionPluralCascadeDeletionDbGateway;
        $this->entityCascadeDeletionFactory = $entityPluralCascadeDeletionFactory;
    }

    public function make(): EntityPluralCascadeDeletionInterface
    {
        return new SectionCascadeDeletionService(
            $this->cascadeDeletionDbGateway,
            $this->entityCascadeDeletionFactory->make()
        );
    }
}
