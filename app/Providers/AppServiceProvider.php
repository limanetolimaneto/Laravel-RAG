<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use App\Services\DocumentParserInterface;
// use App\Services\TXTParserService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->app->bind(DocumentParserInterface::class, TXTParserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
