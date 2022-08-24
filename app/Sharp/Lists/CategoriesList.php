<?php
declare(strict_types=1);

namespace App\Sharp\Lists;

use App\Models\Categories\SuperCategory;
use App\Sharp\Commands\ChildDocumentsLink;
use App\Sharp\Filters\SuperCategoryFilter;
use Code16\Sharp\EntityList\Containers\EntityListDataContainer;
use Code16\Sharp\EntityList\EntityListQueryParams;
use Code16\Sharp\EntityList\SharpEntityList;
use App\Models\Categories\Category;
use Code16\Sharp\Exceptions\SharpException;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class CategoriesList
 * @package App\Sharp
 */
class CategoriesList extends SharpEntityList
{
    /**
     * Build list containers using ->addDataContainer()
     *
     * @return void
     */
    public function buildListDataContainers()
    {
        $this
            ->addDataContainer(
            EntityListDataContainer::make('name')
                ->setLabel('Название')
                ->setSortable()
        )->addDataContainer(
            EntityListDataContainer::make("super_category_id")
                ->setLabel("Супер категория")
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
        $this
            ->addColumn('name', 3,2)
            ->addColumn('super_category_id', 2,2)
            ->addColumn('created_at', 3,3)
            ->addColumn('id', 3,3)
        ;
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
                'get_link', ChildDocumentsLink::class
            )
            ->setPaginated()
            ->addFilter(SuperCategory::FILTER_NAME, SuperCategoryFilter::class);
    }

	/**
	* Retrieve all rows data as array.
	*
	* @param EntityListQueryParams $params
    * @return array|LengthAwarePaginator
    */
    public function getListData(EntityListQueryParams $params)
    {
        $categories = Category::orderBy(
            $params->sortedBy(), $params->sortedDir()
        );

        if ($superCategory = $params->filterFor(SuperCategory::FILTER_NAME)) {
            $categories->where("super_category_id", $superCategory);
        }

        collect($params->searchWords())
            ->each(function($word) use($categories) {
                $categories->where(function ($query) use ($word) {
                    $query->orWhere('name', 'like', $word)
                        ->orWhere('description', 'like', $word);
                });
            });

        return $this->transform($categories->paginate(20));
    }
}
