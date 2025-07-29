<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\DestinasiRepositoryInterface; // Import the interface
use App\Repositories\DestinasiRepository;
use Illuminate\Support\Facades\URL;

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
        if (str_contains(request()->url(), 'ngrok-free.app')) {
            URL::forceScheme('https');
        }
    }
}
