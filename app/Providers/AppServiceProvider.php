<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\DestinasiRepositoryInterface; // Import the interface
use App\Repositories\DestinasiRepository;  

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->app->bind(
        //     DestinasiRepositoryInterface::class,
        //     DestinasiRepository::class
        // );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
