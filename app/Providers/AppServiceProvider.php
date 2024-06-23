<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Knuckles\Camel\Extraction\ExtractedEndpointData;
use Symfony\Component\HttpFoundation\Request;
use Knuckles\Scribe\Scribe;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (class_exists(\Knuckles\Scribe\Scribe::class)) {
            Scribe::beforeResponseCall(function (Request $request, ExtractedEndpointData $endpointData) {
                $user = User::where('username', 'scribe')->first();
                $token = $user?->createToken('scribe')?->plainTextToken;
                $request->headers->add(["Authorization" => "Bearer $token"]);
            });
        }
    }
}
