<?php
declare(strict_types=1);

namespace App\Components\Article\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;
use App\Models\Documents\Article;
use Illuminate\Support\Arr;

class ArticlePresenter implements EntityPresenterInterface
{
    /**
     * @param Article|object|array $entity
     *
     * @return array
     */
    public function format($entity): array
    {
        if (is_array($entity)) {
            $formatted = Arr::only($entity, [
                'id',
                'name',
                'text',
                'section_id',
                'created_at',
                'updated_at',
                'deleted_at',
            ]);
        } else {
            $formatted = [
                'id' => $entity->id,
                'name' => $entity->name,
                'text' => $entity->text,
                'section_id' => $entity->section_id,

                'created_at' => $entity->created_at,
                'updated_at' => $entity->updated_at,
                'deleted_at' => $entity->deleted_at,
            ];
        }

        return $formatted;
    }
}
