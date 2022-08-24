<?php
declare(strict_types=1);

namespace App\Components\Admin\Document;

use App\Components\Admin\Document\DbGateways\DocumentPluralCascadeDeletionDbGateway;
use App\Components\Admin\Entity\Contracts\DbGateways\EntityPluralCascadeDeletionDbGatewayInterface;
use App\Components\Admin\Entity\Contracts\EntityPluralCascadeDeletionFactoryInterface;
use App\Components\Admin\Entity\Contracts\EntityPluralCascadeDeletionInterface;
use App\Components\Admin\Section\SectionPluralCascadeDeletionFactory;

class DocumentPluralCascadeDeletionFactory implements EntityPluralCascadeDeletionFactoryInterface
{
    private EntityPluralCascadeDeletionDbGatewayInterface $cascadeDeletionDbGateway;

    private EntityPluralCascadeDeletionFactoryInterface $entityCascadeDeletionFactory;

    public function __construct(
        DocumentPluralCascadeDeletionDbGateway $documentPluralCascadeDeletionDbGateway,
        SectionPluralCascadeDeletionFactory $entityPluralCascadeDeletionFactory
    ) {
        $this->cascadeDeletionDbGateway = $documentPluralCascadeDeletionDbGateway;
        $this->entityCascadeDeletionFactory = $entityPluralCascadeDeletionFactory;
    }

    public function make(): EntityPluralCascadeDeletionInterface
    {
        return new DocumentCascadeDeletionService(
            $this->cascadeDeletionDbGateway,
            $this->entityCascadeDeletionFactory->make()
        );
    }
}
