<?php

namespace App\Providers;

use App\Services\ReleaseService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerReleasesForMigrations();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * It registers the release directories for
     * migrations
     * @return void
     */
    private function registerReleasesForMigrations(): void
    {
        $releases = (new ReleaseService)->get();
        $this->loadMigrationsFrom(array_map(function ($release) {
            return database_path('migrations/' . $release);
        },$releases));
    }
}
