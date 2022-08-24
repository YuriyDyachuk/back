<?php
declare(strict_types=1);

namespace App\Components\Entity\DbGateways;

use Illuminate\Database\Eloquent\Builder;

trait EloquentEntityPaginatedTrait
{
    use EloquentAbstractModelTrait;

    public function getPaginated(array $options): array
    {
        /** @var Builder $query */
        $query = $this->getModelClassname()::query();

        return $query->paginate($options['limit'] ?? 40)
            ->toArray();
    }
}
