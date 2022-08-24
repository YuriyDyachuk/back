<?php
declare(strict_types=1);

namespace App\Sharp;

use App\Models\Subscription;
use App\Models\User;
use Code16\Sharp\EntityList\Containers\EntityListDataContainer;
use Code16\Sharp\EntityList\EntityListQueryParams;
use Code16\Sharp\EntityList\SharpEntityList;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class UsersList
 * @package App\Sharp
 */
class UsersList extends SharpEntityList
{
    /**
    * Build list containers using ->addDataContainer()
    *
    * @return void
    */
    public function buildListDataContainers()
    {
        $this->addDataContainer(
            EntityListDataContainer::make('name')
                ->setLabel('Name')
                ->setSortable()
        )->addDataContainer(
            EntityListDataContainer::make("email")
                ->setLabel("email")
                ->setSortable()
        )->addDataContainer(
            EntityListDataContainer::make("subscription_type")
                ->setLabel("Тип подписки")
                ->setSortable()
                ->setHtml()
        )->addDataContainer(
            EntityListDataContainer::make('photo_url')
                ->setLabel('Фото')
                ->setHtml()
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
        $this->addColumn('name', 2,2)
             ->addColumn('email', 2,3)
             ->addColumn('created_at', 3,3)
             ->addColumn('subscription_type', 2,3)
             ->addColumn('photo_url', 2,3);
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
            ->setDefaultSort('name', 'asc')
            ->setPaginated();
    }

    /**
     * @param EntityListQueryParams $params
     * @return array|LengthAwarePaginator
     */
    public function getListData(EntityListQueryParams $params)
    {
        $users = User::with('subscription')->orderBy(
            $params->sortedBy(), $params->sortedDir()
        );

        collect($params->searchWords())
            ->each(function($word) use($users) {
                $users->where(function ($query) use ($word) {
                    $query->orWhere('name', 'like', $word)
                        ->orWhere('email', 'like', $word);
                });
            });

        return $this
            ->setCustomTransformer("subscription_type", function($subscription_type) {
                $subscription = Subscription::where('id', $subscription_type)
                    ->take(1)
                    ->get('name')->first();
                if (!empty($subscription->name)) {
                    return $subscription->name;
                }
            })
            ->setCustomTransformer('photo_url', function($photo_url) {
                if ($photo_url) {
                    return '<img class="img-thumbnail" src="'. $photo_url. '">';
                }
            })
            ->transform(
                $users->paginate(30)
            );
    }
}
