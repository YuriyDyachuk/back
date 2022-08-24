<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddApiVersion
{
    /**
     * Add api version to outgoing response.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return JsonResponse|Response
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var Response $response */
        $response = $next($request);
        if ($request->expectsJson() && !$response->isEmpty()) {
            /** @var JsonResponse $response */
            $data = $response->getData(true);

            $data['jsonapi']['version'] = config('app.version');

            $response->setData($data);
        }

        return $response;
    }
}
