<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // Correct namespace
use Intervention\Image\Facades\Image;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Use Bootstrap 4 for pagination styling
        Paginator::useBootstrapFive();

        $driver = config('image.driver');

        // Set the driver dynamically
        Image::configure(['driver' => $driver]);
    }
}
