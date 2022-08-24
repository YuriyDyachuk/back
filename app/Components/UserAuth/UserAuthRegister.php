<?php
declare(strict_types=1);

namespace App\Components\UserAuth;

use App\Components\UserAuth\Contracts\DbGateways\UserRegisterDbGatewayInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Psr\ApiAuth\Contracts\AuthenticableRegisterInterface;

/**
 * Class UserAuthRegister
 * @package App\Components\UserAuth
 */
class UserAuthRegister implements AuthenticableRegisterInterface
{
    /**
     * @var UserRegisterDbGatewayInterface
     */
    private UserRegisterDbGatewayInterface $registerDbGateway;

    /**
     * UserAuthRegister constructor.
     * @param UserRegisterDbGatewayInterface $registerDbGateway
     */
    public function __construct(UserRegisterDbGatewayInterface $registerDbGateway)
    {
        $this->registerDbGateway = $registerDbGateway;
    }

    /**
     * @param array $registrable
     * @return array
     */
    public function register(array $registrable): array
    {
        return $this->registerDbGateway->store(
            $this->getUserAttributes($registrable)
        );
    }

    /**
     * @param array $registrable
     * @return array
     */
    private function getUserAttributes(array $registrable): array
    {
        $userAttributes = Arr::only($registrable, [
            'name',
            'email',
            'password',
            'photo_url',
        ]);

        $userAttributes['password'] = Hash::make($userAttributes['password']);

        $userAttributes['type'] = 0; // todo complete
        $userAttributes['subscription_type'] = 0; // todo complete

        return $userAttributes;
    }
}
