<?php

namespace App\Providers;

use App\Services\ReleaseService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class MigrationProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Log::info('booting.... migration service provider....');
    }
}
