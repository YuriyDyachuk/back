<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Models\LinkedSocialAccount;
use Laravel\Socialite\Two\User as ProviderUser;

/**
 * Class SocialAccountsService
 * @package App\Services
 */
class SocialAccountsService
{
    /**
     * Find or create user instance by provider user instance and provider name.
     *
     * @param ProviderUser $providerUser
     * @param string $provider
     *
     * @return User
     */
    public function findOrCreate(ProviderUser $providerUser, string $provider): User
    {
        $linkedSocialAccount = LinkedSocialAccount::where([LinkedSocialAccount::PROVIDER_NAME => $provider])
            ->where('provider_id', $providerUser->getId())
            ->first();

        if ($linkedSocialAccount) {
            return $linkedSocialAccount->user;
        } else {
            $user = null;

            if ($email = $providerUser->getEmail()) {
                $user = User::where(['email' => $email])->first();
            }

            if (!$user) {
                $user = User::create([
                    'first_name' => $providerUser->getName(),
                    'last_name' => $providerUser->getName(),
                    'email' => $providerUser->getEmail(),
                ]);
            }

            $user->linkedSocialAccounts()->create([
                LinkedSocialAccount::PROVIDER_ID   => $providerUser->getId(),
                LinkedSocialAccount::PROVIDER_NAME => $provider,
            ]);

            return $user;
        }
    }
}
