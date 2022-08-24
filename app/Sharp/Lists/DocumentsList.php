<?php

namespace App\Sharp\Lists;

use App\Models\Documents\Document;
use App\Sharp\Commands\ChildSectionsLink;
use App\Sharp\Commands\InsideDocumentsLink;
use App\Sharp\Filters\CategoryFilter;
use Code16\Sharp\EntityList\Containers\EntityListDataContainer;
use Code16\Sharp\EntityList\EntityListQueryParams;
use Code16\Sharp\EntityList\SharpEntityList;
use Code16\Sharp\Exceptions\SharpException;
use Illuminate\Pagination\LengthAwarePaginator;

class DocumentsList extends SharpEntityList
{
    /**
     * Build list containers using ->addDataContainer()
     *
     * @return void
     */
    public function buildListDataContainers()
    {
        $this->addDataContainer(
            EntityListDataContainer::make('id')
                ->setLabel("ID")
                ->setSortable()
        )->addDataContainer(
            EntityListDataContainer::make('name')
                ->setLabel('Название')
                ->setSortable()
        )->addDataContainer(
            EntityListDataContainer::make("description")
                ->setLabel("Описание")
                ->setSortable()
        )->addDataContainer(
            EntityListDataContainer::make('url')
                ->setLabel('URL')
                ->setSortable()
        )->addDataContainer(
            EntityListDataContainer::make("created_at")
                ->setLabel("Created")
                ->setSortable()
        );
    }

    /**
    * Build list layout using ->addColumn()
    *
    * @return void
    */
    public function buildListLayout()
    {
        $this->addColumn('id', 1,1)
            ->addColumn('name', 3,2)
            ->addColumn('description', 2,2)
            ->addColumn('created_at', 3,3);
    }

    /**
     * Build list config
     *
     * @return void
     * @throws SharpException
     */
    public function buildListConfig()
    {
        $this->setInstanceIdAttribute('id')
            ->setSearchable()
            ->setDefaultSort('id', 'asc')
            ->setPaginated()
            ->addInstanceCommand(
                'get_link', ChildSectionsLink::class,
               // 'get_link', InsideDocumentsLink::class
            )
            ->addFilter("Категория", CategoryFilter::class);
    }

	/**
	* Retrieve all rows data as array.
	*
    * @param EntityListQueryParams $params
    * @return array|LengthAwarePaginator
    */
    public function getListData(EntityListQueryParams $params)
    {
        $documents = Document::orderBy(
            $params->sortedBy(), $params->sortedDir()
        );

        if($category = $params->filterFor("Категория")) {
            $documents->where("category_id", $category);
        }

        collect($params->searchWords())
            ->each(function($word) use($documents) {
                $documents->where(function ($query) use ($word) {
                    $query->orWhere('name', 'like', $word)
                        ->orWhere('description', 'like', $word);
                });
            });

        return $this->transform($documents->paginate(20));
    }
}
