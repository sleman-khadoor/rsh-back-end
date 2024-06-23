<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HasRolesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = Auth::user();

        if($user->hasRole(Role::getSuperAdminRole())) return $next($request);

        foreach($roles as $role) {

            if($user->hasRole($role)) return $next($request);
        }

        return response()->json(['message' => config('response-messages.auth.unauthorized')
                    ], Response::HTTP_UNAUTHORIZED);

    }
}
