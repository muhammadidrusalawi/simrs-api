<?php

namespace App\Http\Middleware;

use App\Helper\ResponseHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!in_array(Auth::user()->role, $roles)) {
            return ResponseHelper::apiError(
                'Unauthorized',
                'You do not have the required role to access this resource.',
                Response::HTTP_FORBIDDEN
            );
        }

        return $next($request);
    }
}
