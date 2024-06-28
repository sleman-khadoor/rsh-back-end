<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = config('core-config.langs');
        $locale = $request->header('lang');

        if($request->is('api/admin/*')) {

            $locale = $supportedLocales['english'];
        } else {

            if(!in_array($locale, $supportedLocales)) {
                $locale = $supportedLocales['english'];
            }
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
