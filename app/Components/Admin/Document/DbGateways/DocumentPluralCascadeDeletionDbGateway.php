<?php
declare(strict_types=1);

namespace App\Components\Admin\Document\DbGateways;

use App\Components\Admin\Entity\Contracts\DbGateways\EntityPluralCascadeDeletionDbGatewayInterface;
use App\Components\Entity\DbGateways\EloquentGetPureModelInstanceTrait;
use App\Models\Documents\Document;

class DocumentPluralCascadeDeletionDbGateway implements EntityPluralCascadeDeletionDbGatewayInterface
{
    use EloquentGetPureModelInstanceTrait;

    /**
     * @inheritDoc
     */
    public function selectIdsByForeignKey(int $foreignKey): array
    {
        /** @var Document $pureModel */
        $pureModel = $this->getModelInstance();

        return $pureModel->query()
            ->select(
                $pureModel->getKeyName()
            )
            ->where(
                $pureModel->category()->getForeignKeyName(),
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
        /** @var Document $pureModel */
        $pureModel = $this->getModelInstance();

        return $pureModel->query()
            ->select(
                $pureModel->getKeyName()
            )
            ->whereIn(
                $pureModel->category()->getForeignKeyName(),
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
        return Document::class;
    }
}
