<?php
declare(strict_types=1);

namespace App\Components\Admin\Article\DbGateways;

use App\Components\Admin\Entity\Contracts\DbGateways\EntityPluralCascadeDeletionDbGatewayInterface;
use App\Components\Entity\DbGateways\EloquentGetPureModelInstanceTrait;
use App\Models\Documents\Article;

class ArticlePluralCascadeDeletionDbGateway implements EntityPluralCascadeDeletionDbGatewayInterface
{
    use EloquentGetPureModelInstanceTrait;

    /**
     * @inheritDoc
     */
    public function selectIdsByForeignKey(int $foreignKey): array
    {
        /** @var Article $pureModel */
        $pureModel = $this->getModelInstance();

        return $pureModel->query()
            ->select(
                $pureModel->getKeyName()
            )
            ->where(
                $pureModel->section()->getForeignKeyName(),
                $foreignKey,
            )
            ->get()
            ->toArray();
    }

    /**
     * @inheritDoc
     */
    public function selectIdsByForeignKeys(array $foreignKeys): array
    {
        /** @var Article $pureModel */
        $pureModel = $this->getModelInstance();

        return $pureModel->query()
            ->select(
                $pureModel->getKeyName()
            )
            ->whereIn(
                $pureModel->section()->getForeignKeyName(),
                $foreignKeys,
            )
            ->get()
            ->toArray();
    }

    /**
     * @inheritDoc
     */
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
        return Article::class;
    }
}
