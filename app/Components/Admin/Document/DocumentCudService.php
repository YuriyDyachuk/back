<?php
declare(strict_types=1);

namespace App\Components\Admin\Document;

use App\Components\Admin\Entity\Contracts\DbGateways\EntityCudDbGatewayInterface;
use App\Components\Admin\Entity\Contracts\EntityCascadeDeletionInterface;
use App\Components\Admin\Entity\Contracts\EntityCudInterface;
use Illuminate\Support\Arr;

class DocumentCudService implements EntityCudInterface
{
    private EntityCudDbGatewayInterface $cudDbGateway;

    private EntityCascadeDeletionInterface $entityCascadeDeletionService;

    public function __construct(
        EntityCudDbGatewayInterface $entityCudDbGateway,
        EntityCascadeDeletionInterface $entityCascadeDeletionService
    ) {
        $this->cudDbGateway = $entityCudDbGateway;
        $this->entityCascadeDeletionService = $entityCascadeDeletionService;
    }

    /**
     * @inheritDoc
     */
    public function makeStore(array $data): object
    {
        return $this->cudDbGateway->create(
            $this->getAttributesFromData($data)
        );
    }

    /**
     * @inheritDoc
     */
    public function makeUpdate(array $updatable): object
    {
        $this->cudDbGateway->update(
            $this->getAttributesFromData($updatable['data']),
            $updatable['entity'],
        );

        return $updatable['entity'];
    }

    /**
     * @inheritDoc
     */
    public function makeDelete(object $deletable): object
    {
        $this->entityCascadeDeletionService->deleteRelatedByForeignKey(
            $deletable->getKey()
        );

        $this->cudDbGateway->delete($deletable);

        return $deletable;
    }

    private function getAttributesFromData(array $data): array
    {
        $attributes = Arr::only($data, [
            'name',
            'description',
            'url',
        ]);
        if (isset($data['categoryId'])) {
            $attributes['category_id'] = $data['categoryId'];
        }

        return $attributes;
    }
}
