<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

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
        Response::macro('success', function ($data) {
            return Response::json([
                'status' => true,
                'data' => $data,
            ]);
        });
        Response::macro('error', function ($data) {
            return Response::json([
                'status' => false,
                'data' => $data,
            ]);
        });
    }
}
