<?php

namespace App\Providers;

use App\Models\FeedRecord;
use App\Observers\FeedRecordObserver;
use Illuminate\Support\ServiceProvider;

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
        FeedRecord::observe(FeedRecordObserver::class);
    }
}
