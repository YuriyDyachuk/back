<?php
declare(strict_types=1);

namespace App\Components\Document\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;
use App\Models\Documents\Document;
use Illuminate\Support\Arr;

class DocumentPresenter implements EntityPresenterInterface
{
    /**
     * @param Document|object|array $entity
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
                'url',
                'category_id',
                'created_at',
                'updated_at',
                'deleted_at',
            ]);
        } else {
            $formatted = [
                'id' => $entity->id,
                'name' => $entity->name,
                'description' => $entity->description,
                'url' => $entity->url,
                'category_id' => $entity->category_id,

                'created_at' => $entity->created_at,
                'updated_at' => $entity->updated_at,
                'deleted_at' => $entity->deleted_at,
            ];
        }

        return $formatted;
    }
}
