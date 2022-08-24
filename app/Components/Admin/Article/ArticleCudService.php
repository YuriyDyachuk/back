<?php
declare(strict_types=1);

namespace App\Components\Admin\Article;

use App\Components\Admin\Entity\Contracts\DbGateways\EntityCudDbGatewayInterface;
use App\Components\Admin\Entity\Contracts\EntityCudInterface;
use Illuminate\Support\Arr;

class ArticleCudService implements EntityCudInterface
{
    private EntityCudDbGatewayInterface $cudDbGateway;

    public function __construct(EntityCudDbGatewayInterface $entityCudDbGateway)
    {
        $this->cudDbGateway = $entityCudDbGateway;
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
        $this->cudDbGateway->delete($deletable);

        return $deletable;
    }

    private function getAttributesFromData(array $data): array
    {
        $attributes = Arr::only($data, [
            'name',
            'text',
        ]);
        if (isset($data['sectionId'])) {
            $attributes['section_id'] = $data['sectionId'];
        }

        return $attributes;
    }
}
