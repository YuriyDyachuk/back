<?php
declare(strict_types=1);

namespace App\Components\Admin\Category\DbGateways;

use App\Components\Admin\Entity\Contracts\DbGateways\EntityCascadeDeletionDbGatewayInterface;
use App\Components\Entity\DbGateways\EloquentGetPureModelInstanceTrait;
use App\Models\Categories\Category;

class CategoryCascadeDeletionDbGateway implements EntityCascadeDeletionDbGatewayInterface
{
    use EloquentGetPureModelInstanceTrait;

    public function selectIdsByForeignKey(int $foreignKey): array
    {
        /** @var Category $pureModel */
        $pureModel = $this->getModelInstance();

        return $pureModel->query()
            ->select(
                $pureModel->getKeyName()
            )
            ->where(
                $pureModel->superCategory()->getForeignKeyName(),
                $foreignKey,
            )
            ->get()
            ->toArray();
    }

    public function deleteByIds(array $ids): void
    {
        $pureModel = $this->getModelInstance();

        $pureModel->query()
            ->whereIn(
                $pureModel->getKeyName(),
                $ids
            )
            ->delete();
    }

    protected function getModelClassname(): string
    {
        return Category::class;
    }
}
