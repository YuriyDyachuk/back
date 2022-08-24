<?php
declare(strict_types=1);

namespace App\Sharp\Lists;

use App\Models\Documents\Section;
use App\Sharp\Commands\ChildArticlesLink;
use App\Sharp\Filters\DocumentFilter;
use Code16\Sharp\EntityList\Containers\EntityListDataContainer;
use Code16\Sharp\EntityList\EntityListQueryParams;
use Code16\Sharp\EntityList\SharpEntityList;
use Code16\Sharp\Exceptions\SharpException;

/**
 * Class SectionsList
 * @package App\Sharp\Lists
 */
class SectionsList extends SharpEntityList
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
                'get_link', ChildArticlesLink::class
            )
            ->addFilter("Документ", DocumentFilter::class);;
    }

	/**
	* Retrieve all rows data as array.
	*
	* @param EntityListQueryParams $params
	* @return array
	*/
    public function getListData(EntityListQueryParams $params)
    {
        $sections = Section::orderBy(
            $params->sortedBy(), $params->sortedDir()
        );

        if($document = $params->filterFor("Документ")) {
            $sections->where("document_id", $document);
        }

        collect($params->searchWords())
            ->each(function($word) use($sections) {
                $sections->where(function ($query) use ($word) {
                    $query->orWhere('name', 'like', $word)
                        ->orWhere('description', 'like', $word);
                });
            });

        return $this->transform($sections->paginate(20));
    }
}
