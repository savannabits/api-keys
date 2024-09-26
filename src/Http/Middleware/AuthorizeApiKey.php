<?php
namespace Savannabits\ApiKeys\Http\Middleware;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Savannabits\ApiKeys\Models\ApiKey;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AuthorizeApiKey
{
    /**
     * @throws AuthenticationException
     */
    public function handle($request, $next)
    {
        $authHeader = config('api-keys.authorization_header');
        $apiKey = $request->header($authHeader);
        if (!$apiKey) {
            throw new AuthenticationException('Access denied. Invalid API Key.');
        }
        $key = ApiKey::getByKey($apiKey);

        if (!$key) {
            throw new AuthenticationException('Access denied. Invalid API Key.');
        }
        // Log the access event
        $key->logAccess($request);
        return $next($request);
    }
}