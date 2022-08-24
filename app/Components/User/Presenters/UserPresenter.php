<?php
declare(strict_types=1);

namespace App\Components\User\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;
use App\Models\User;

class UserPresenter implements EntityPresenterInterface
{
    /**
     * @inheritDoc
     */
    public function format($entity): array
    {
        $array = [
            'id' => $entity->id,
            'name' => $entity->name,
            'email' => $entity->email,
            'photo_url' => $entity->photo_url,
            'type' => $entity->type,
            'role' => $entity->role_id,
            'subscription_type' => $entity->subscription_type,
            'subscribed_to' => $entity->subscribed_to,
            'email_verified_at' => $entity->email_verified_at,
            'created_at' => $entity->created_at,
            'updated_at' => $entity->updated_at,
        ];

         if (!empty($entity->linkedSocialAccounts)) {
             $accountsArray = [];
             foreach ($entity->linkedSocialAccounts as $account) {
                 array_push($accountsArray, [
                     'provider' => $account->provider_name,
                     'status' =>  $account->status,
                 ]);
             }
             $array['linked_social_accounts'] = $accountsArray;
         }

        if (!empty($entity->subscription) && is_object( $entity->subscription)) {
            $array['subscription'] = [
                'subscription_id' => $entity->subscription->id,
                'title' =>  $entity->subscription->name,
                User::SUBSCRIBED_TO => $entity->{User::SUBSCRIBED_TO}
            ];
        }

        return $array;
    }
}
