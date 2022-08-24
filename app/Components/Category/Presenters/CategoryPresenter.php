<?php
declare(strict_types=1);

namespace App\Components\Category\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;
use App\Models\Categories\Category;
use Illuminate\Support\Arr;

class CategoryPresenter implements EntityPresenterInterface
{
    /**
     * @param Category|object|array $entity
     *
     * @return array
     */
    public function format($entity): array
    {
        if (is_array($entity)) {
            $formatted = Arr::only($entity, [
                'id',
                'name',
                'description',
                'super_category_id',
                'created_at',
                'updated_at',
                'deleted_at',
            ]);
        } else {
            $formatted = [
                'id' => $entity->id,
                'name' => $entity->name,
                'description' => $entity->description,
                'super_category_id' => $entity->super_category_id,

                'created_at' => $entity->created_at,
                'updated_at' => $entity->updated_at,
                'deleted_at' => $entity->deleted_at,
            ];
        }

        return $formatted;
    }
}
