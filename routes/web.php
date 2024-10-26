<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\HomePage::class)->name('homePage');
Route::get('/how-to-book', \App\Livewire\HowToBookPage::class)->name('howToBook');
Route::get('/application/{id}', \App\Livewire\ApplicationPage::class)->name('application');
Route::get('/detail-room/{id}', \App\Livewire\DetailRoom::class)->name('detail-room');


Route::get('/testing', function () {
    return view('welcome');
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
