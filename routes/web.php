<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group( function () {
    Route::get('/', \App\Livewire\HomePage::class)->name('homePage');
    Route::get('/how-to-book', \App\Livewire\HowToBookPage::class)->name('howToBook');
    Route::get('/application/{id}', \App\Livewire\ApplicationPage::class)->name('application');
    Route::get('/detail-room/{id}', \App\Livewire\DetailRoom::class)->name('detail-room');
    Route::get('/room/category/{categoryName}', \App\Livewire\ViewRoomPage::class)->name('view-room');
});
