<?php
declare(strict_types=1);

namespace App\Components\Admin\Entity\DbGateways;

use App\Components\Admin\Entity\Contracts\DbGateways\EntityCudDbGatewayInterface;
use App\Components\Entity\DbGateways\EloquentAbstractModelTrait;
use Exception;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractEloquentEntityCudDbGateway implements EntityCudDbGatewayInterface
{
    use EloquentAbstractModelTrait;

    /**
     * @inheritDoc
     */
    public function create(array $attributes): object
    {
        /** @var Builder $query */
        $query = $this->getModelClassname()::query();

        return $query->create($attributes);
    }

    /**
     * @inheritDoc
     */
    public function update(array $attributes, object $entity): void
    {
        $entity->update($attributes);
    }

    /**
     * @inheritDoc
     *
     * @throws Exception
     */
    public function delete(object $entity): void
    {
        $entity->delete();
    }
}
