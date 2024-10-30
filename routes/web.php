<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group( function () {
    Route::get('/', \App\Livewire\HomePage::class)->name('homePage');
    Route::get('/how-to-book', \App\Livewire\HowToBookPage::class)->name('howToBook');
    Route::get('/application/{id}', \App\Livewire\ApplicationPage::class)->name('application');
    Route::get('/detail-room/{id}', \App\Livewire\DetailRoom::class)->name('detail-room');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('/testing', function () {
    return view('welcome');
});

//FOR TESTING
Route::get('/env-check', function() {
    $envPath = base_path('.env');
    $output = [
        'env_exists' => file_exists($envPath),
        'env_size' => file_exists($envPath) ? filesize($envPath) : 0,
        'env_readable' => file_exists($envPath) ? is_readable($envPath) : false,
        'app_key' => env('APP_KEY', 'not-set'),
        'app_env' => env('APP_ENV', 'not-set'),
        'db_connection' => env('DB_CONNECTION', 'not-set'),
    ];

    return response()->json($output);
});
