<?php
declare(strict_types=1);

namespace App\Components\Section\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;
use App\Models\Documents\Section;
use Illuminate\Support\Arr;

class SectionPresenter implements EntityPresenterInterface
{
    /**
     * @param Section|object|array $entity
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
                'document_id',
                'created_at',
                'updated_at',
                'deleted_at',
            ]);
        } else {
            $formatted = [
                'id' => $entity->id,
                'name' => $entity->name,
                'description' => $entity->description,
                'document_id' => $entity->document_id,

                'created_at' => $entity->created_at,
                'updated_at' => $entity->updated_at,
                'deleted_at' => $entity->deleted_at,
            ];
        }

        return $formatted;
    }
}
