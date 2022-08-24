<?php
declare(strict_types=1);

namespace App\Sharp\Lists;

use App\Models\Documents\Article;
use App\Sharp\Filters\SectionFilter;
use Code16\Sharp\EntityList\Containers\EntityListDataContainer;
use Code16\Sharp\EntityList\EntityListQueryParams;
use Code16\Sharp\EntityList\SharpEntityList;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class ArticlesList
 * @package App\Sharp
 */
class ArticlesList extends SharpEntityList
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
                    ->setLabel('id')
                    ->setSortable())
            ->addDataContainer(
            EntityListDataContainer::make('name')
                ->setLabel('Name')
                ->setSortable())
            ->addDataContainer(
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
            ->addColumn('name', 4,3)
            ->addColumn('created_at', 4,3);
    }

    /**
    * Build list config
    *
    * @return void
    */
    public function buildListConfig()
    {
        $this->setInstanceIdAttribute('id')
            ->setSearchable()
            ->setDefaultSort('id', 'asc')
            ->setPaginated()
            ->addFilter("Секция", SectionFilter::class);
    }

	 /**
	 * Retrieve all rows data as array.
	 *
     * @param EntityListQueryParams $params
     * @return array|LengthAwarePaginator
     */
    public function getListData(EntityListQueryParams $params)
    {
        $articles = Article::orderBy(
            $params->sortedBy(), $params->sortedDir()
        );

        if($section = $params->filterFor("Секция")) {
            $articles->where("section_id", $section);
        }

        collect($params->searchWords())
            ->each(function($word) use($articles) {
                $articles->where(function ($query) use ($word) {
                    $query->orWhere('name', 'like', $word)
                        ->orWhere('text', 'like', $word);
                });
            });

        return $this->transform($articles->paginate(20));
    }
}
