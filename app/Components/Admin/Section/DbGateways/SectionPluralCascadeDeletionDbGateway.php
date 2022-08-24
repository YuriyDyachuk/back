<?php
declare(strict_types=1);

namespace App\Components\Admin\Section\DbGateways;

use App\Components\Admin\Entity\Contracts\DbGateways\EntityPluralCascadeDeletionDbGatewayInterface;
use App\Components\Entity\DbGateways\EloquentGetPureModelInstanceTrait;
use App\Models\Documents\Section;

class SectionPluralCascadeDeletionDbGateway implements EntityPluralCascadeDeletionDbGatewayInterface
{
    use EloquentGetPureModelInstanceTrait;

    /**
     * @inheritDoc
     */
    public function selectIdsByForeignKey(int $foreignKey): array
    {
        /** @var Section $pureModel */
        $pureModel = $this->getModelInstance();

        return $pureModel->query()
            ->select(
                $pureModel->getKeyName()
            )
            ->where(
                $pureModel->document()->getForeignKeyName(),
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
        /** @var Section $pureModel */
        $pureModel = $this->getModelInstance();

        return $pureModel->query()
            ->select(
                $pureModel->getKeyName()
            )
            ->whereIn(
                $pureModel->document()->getForeignKeyName(),
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
        return Section::class;
    }
}
