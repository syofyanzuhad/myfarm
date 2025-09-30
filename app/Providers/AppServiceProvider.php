<?php

namespace App\Providers;

use App\Models\FeedRecord;
use App\Observers\FeedRecordObserver;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
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

        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_START,
            fn (): string => Blade::render(<<<'HTML'
                <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
                <meta name="mobile-web-app-capable" content="yes">
                <meta name="apple-mobile-web-app-capable" content="yes">
                <meta name="apple-mobile-web-app-status-bar-style" content="default">
                <meta name="apple-mobile-web-app-title" content="MyFarm">
                <meta name="theme-color" content="#f59e0b">
                <link rel="manifest" href="/manifest.json">
                <link rel="apple-touch-icon" href="/icon-192.svg">
            HTML)
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_END,
            fn (): string => Blade::render(<<<'HTML'
                <script>
                    if ('serviceWorker' in navigator) {
                        window.addEventListener('load', function() {
                            navigator.serviceWorker.register('/sw.js')
                                .then(function(registration) {
                                    console.log('ServiceWorker registered:', registration.scope);
                                })
                                .catch(function(error) {
                                    console.log('ServiceWorker registration failed:', error);
                                });
                        });
                    }
                </script>
            HTML)
        );
    }
}
