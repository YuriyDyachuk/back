<?php
declare(strict_types=1);

namespace App\Components\EntitiesSynchronizer\DbGateways;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

trait QuerySyncDbGatewayTrait
{
    public function isSynchronized(int $lastSyncTimestamp): bool
    {
        $lastSyncDatetime = Date::createFromTimestamp($lastSyncTimestamp)->format('Y-m-d');

        return DB::table($this->getTable())
            ->whereExists(function (Builder $q) use ($lastSyncDatetime) {
                $q->select('*')
                    ->from($this->getTable())
                    ->where($this->getCreatedAtColumn(), '>=', $lastSyncDatetime)
                    ->orWhere($this->getUpdatedAtColumn(), '>=', $lastSyncDatetime)
                    ->orWhere($this->getDeletedAtColumn(), '>=', $lastSyncDatetime);
            })
            ->exists();
    }

    public function getUpdatesPaginated(int $lastSyncTimestamp, array $options): array
    {
        $lastSyncDatetime = Date::createFromTimestamp($lastSyncTimestamp)->format('Y-m-d');

//        return DB::table($this->getTable())
//            ->where('allowed_roles', 'like', '%'.$options["user_role"].'%')
//            ->orWhere('allowed_roles', null)
//            //->where($this->getCreatedAtColumn(), '>=', $lastSyncDatetime)
////            ->orWhere($this->getUpdatedAtColumn(), '>=', $lastSyncDatetime)
////            ->orWhere($this->getDeletedAtColumn(), '>=', $lastSyncDatetime)
//            ->where(function (Builder $q) use ($lastSyncDatetime) {
//                $q->where($this->getCreatedAtColumn(), '>=', $lastSyncDatetime)
//                    ->orWhere($this->getUpdatedAtColumn(), '>=', $lastSyncDatetime)
//                    ->orWhere($this->getDeletedAtColumn(), '>=', $lastSyncDatetime);
//            })
//
//            ->simplePaginate($options['limit'] ?? 40)
//            ->toArray();




        $query = DB::table($this->getTable())
            ->where(function (Builder $q) use ($lastSyncDatetime) {
                $q->select('*')
                    ->from($this->getTable())
                    ->where($this->getCreatedAtColumn(), '>=', $lastSyncDatetime)
                    ->orWhere($this->getUpdatedAtColumn(), '>=', $lastSyncDatetime)
                    ->orWhere($this->getDeletedAtColumn(), '>=', $lastSyncDatetime);
            });
        if (isset($options["user_role"])) {
             if ($this->getTable() == "super_categories") {
                 $query->where('allowed_roles', 'like', '%'.$options["user_role"].'%')
                     ->orWhere('allowed_roles', null);
             }
             elseif ($this->getTable() == "categories") {
                $query->whereRaw($options["user_role"].' IN (SELECT allowed_roles FROM super_categories WHERE id=categories.super_category_id)');
                $query->orWhere('allowed_roles', 'like', '%'.$options["user_role"].'%');           
                   // ->orWhere('allowed_roles', null);
            }
             elseif ($this->getTable() == "documents") {            
                //  $query->whereRaw($options["user_role"].' IN (SELECT allowed_roles FROM categories WHERE id=documents.category_id)');
                  $query->whereRaw(' INSTR ((SELECT allowed_roles FROM categories WHERE id=documents.category_id), "'.$options["user_role"].'") ');
                 //
             }
             elseif ($this->getTable() == "sections") {
        //          $query->whereRaw($options["user_role"].' IN 
        // (SELECT allowed_roles FROM categories WHERE id=(SELECT category_id FROM documents WHERE id=sections.document_id))');
         $query->whereRaw(' INSTR ( (SELECT allowed_roles FROM categories WHERE id=(SELECT category_id FROM documents WHERE id=sections.document_id)), "'.$options["user_role"].'") 
       ');
             }
             elseif ($this->getTable() == "articles") {
        //          $query->whereRaw($options["user_role"].' IN 
        // (SELECT allowed_roles FROM categories WHERE id=
        // (SELECT category_id FROM documents WHERE id=
        // (SELECT document_id FROM sections WHERE id=articles.section_id)))');
        
               $query->whereRaw(' INSTR( (SELECT allowed_roles FROM categories WHERE id=
        (SELECT category_id FROM documents WHERE id=
        (SELECT document_id FROM sections WHERE id=articles.section_id))), "'.$options["user_role"].'") 
       ');
             }
             else {
//                 $query->whereHas(['categories' => function ($query, $options) {
//                     $query->whereIn('allowed_roles', [$options["user_role"]]);
//                 }]);
//                 $query->join('categories', '1', '=', 'categories.allowed_roles');
               //$query->whereRaw($options["user_role"].' IN (SELECT allowed_roles FROM categories WHERE id=documents.id)');
            }
        }

       //dd($query->toSql());
        return $query->simplePaginate($options['limit'] ?? 60)
            ->toArray();
    }

    abstract protected function getTable(): string;

    abstract protected function getCreatedAtColumn(): string;

    abstract protected function getUpdatedAtColumn(): string;

    abstract protected function getDeletedAtColumn(): string;

    //партак полнейший. переробити нахер
    //    private function getAllowedRoles() {
    //        if ($this->getTable() === "articles") {
    //            $section
    //        }
    //    }
}
