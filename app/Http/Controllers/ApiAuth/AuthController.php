<?php
declare(strict_types=1);

namespace App\Http\Controllers\ApiAuth;

use App\Components\SanctumAuth\Presenters\AuthTokenPresenterFactory;
use App\Components\SanctumAuth\SanctumAuthFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiAuth\LoginRequest;
use App\Http\Requests\ApiAuth\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Psr\ApiAuth\Contracts\AuthenticatorInterface;
use Psr\ApiAuth\Contracts\AuthFactoryInterface;
use Psr\ApiAuth\Contracts\Presenters\AuthPermissionPresenterFactoryInterface;

class AuthController extends Controller
{
    private AuthenticatorInterface $authService;

    private AuthPermissionPresenterFactoryInterface $authPermissionPresenterFactory;

    /**
     * AuthController constructor.
     *
     * @param SanctumAuthFactory|AuthFactoryInterface $authServiceFactory
     * @param AuthTokenPresenterFactory $authPermissionPresenterFactory
     */
    public function __construct(
        SanctumAuthFactory $authServiceFactory,
        AuthTokenPresenterFactory $authPermissionPresenterFactory
    ) {
        $this->authService = $authServiceFactory->make();
        $this->authPermissionPresenterFactory = $authPermissionPresenterFactory;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->authService->login(
            $request->validated()
        );

        $presenter = $this->authPermissionPresenterFactory->make();
        $formatted = $presenter->format($token);

        return response()->json($formatted);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $token = $this->authService->register(
            $request->validated()
        );

        $presenter = $this->authPermissionPresenterFactory->make();
        $formatted = $presenter->format($token);

        return response()->json($formatted);
    }

    public function logout(): Response
    {
        $user = Auth::user();
        $this->authService->logout(
            compact('user')
        );

        return response()->noContent();
    }
}
