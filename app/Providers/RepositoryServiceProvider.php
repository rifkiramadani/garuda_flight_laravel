<?php

namespace App\Providers;

use App\interfaces\AirlineRepositoryInterface;
use App\interfaces\AirportRepositoryInterface;
use App\interfaces\FlightRepositoryInterface;
use App\interfaces\TransactionRepositoryInterface;
use App\Repositories\AirlineRepository;
use App\Repositories\AirportRepository;
use App\Repositories\FlightRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    //mendaftarkan service repositories yang telah dibuat
    public function register(): void
    {
        $this->app->bind(AirlineRepositoryInterface::class, AirlineRepository::class);
        $this->app->bind(AirportRepositoryInterface::class, AirportRepository::class);
        $this->app->bind(FlightRepositoryInterface::class, FlightRepository::class);
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
