<?php

use App\Http\Middleware\HasRolesMiddleware;
use App\Http\Middleware\RequireJson;
use App\Http\Middleware\SetLocaleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append([SetLocaleMiddleware::class, RequireJson::class]);
        $middleware->alias([
            'role' => HasRolesMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        /*
        $exceptions->respond(function(Response $response) {
            if($response->getStatusCode() == 404) {
                return response()->json([
                    'message' => 'Not found'
                ], Response::HTTP_NOT_FOUND);
            }
            if($response->getStatusCode() == 500) {
                return response()->json([
                    'message' => 'Server error'
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return $response;

        });
        */
    })->create();
