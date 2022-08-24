<?php
declare(strict_types=1);
namespace App\Sharp\Lists;

use App\Models\Categories\SuperCategory;
use App\Sharp\Commands\ChildCategoriesLink;
use Code16\Sharp\EntityList\Containers\EntityListDataContainer;
use Code16\Sharp\EntityList\EntityListQueryParams;
use Code16\Sharp\EntityList\SharpEntityList;
use Code16\Sharp\Exceptions\SharpException;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class SuperCategoriesList
 * @package App\Sharp\Lists
 */
class SuperCategoriesList extends SharpEntityList
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
            ->addColumn('name', 4,2)
            ->addColumn('created_at', 4,3);
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
            ->addInstanceCommand(
                'get_link', ChildCategoriesLink::class
            )
            ->setPaginated();
    }

	/**
	* Retrieve all rows data as array.
	*
	* @param EntityListQueryParams $params
    * @return array|LengthAwarePaginator
    */
    public function getListData(EntityListQueryParams $params)
    {
        $superCategories = SuperCategory::orderBy(
            $params->sortedBy(), $params->sortedDir()
        );

        collect($params->searchWords())
            ->each(function($word) use($superCategories) {
                $superCategories->where(function ($query) use ($word) {
                    $query->orWhere('name', 'like', $word)
                        ->orWhere('description', 'like', $word);
                });
            });

        return $this->transform($superCategories->paginate(20));
    }
}
