<?php

namespace App\Providers;

use App\Repositories\PlayerRepository;
use App\Repositories\TournamentRepository;

use App\Interfaces\PlayerRepositoryInterface;
use App\Interfaces\TournamentRepositoryInterface;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TournamentRepositoryInterface::class, TournamentRepository::class);
        $this->app->bind(PlayerRepositoryInterface::class, PlayerRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
