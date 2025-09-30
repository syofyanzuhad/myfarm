<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin/login');

// Debug endpoint - remove after checking
Route::get('/debug-proxy', function () {
    return response()->json([
        'app_url' => config('app.url'),
        'request_scheme' => request()->getScheme(),
        'request_url' => request()->url(),
        'is_secure' => request()->secure(),
        'server_https' => request()->server('HTTPS'),
        'headers' => [
            'X-Forwarded-Proto' => request()->header('X-Forwarded-Proto'),
            'X-Forwarded-Host' => request()->header('X-Forwarded-Host'),
            'X-Forwarded-Port' => request()->header('X-Forwarded-Port'),
            'X-Forwarded-For' => request()->header('X-Forwarded-For'),
            'CF-Visitor' => request()->header('CF-Visitor'),
        ],
        'all_headers' => request()->headers->all(),
    ]);
});

// Route::get('/', function () {
//     return view('welcome');
// });
