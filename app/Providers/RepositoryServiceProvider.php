<?php

namespace App\Providers;

use App\Interfaces\DestinasiRepositoryInterface;
use App\Interfaces\KeberangkatanRepositoryInterface;
use App\Interfaces\MobilRepositoryInterface;
use App\Interfaces\TransaksiRepositoryInterface;
use App\Repositories\KeberangkatanRepository;
use App\Repositories\MobilRepository;
use App\Repositories\TransaksiRepository;
use Appp\Repositories\DestinasiRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MobilRepositoryInterface::class, MobilRepository::class);
        $this->app->bind(DestinasiRepositoryInterface::class, DestinasiRepository::class);
        $this->app->bind(KeberangkatanRepositoryInterface::class, KeberangkatanRepository::class);
        $this->app->bind(TransaksiRepositoryInterface::class, TransaksiRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
