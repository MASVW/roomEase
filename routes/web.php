<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\HomePage::class);
Route::get('/how-to-book', \App\Livewire\HowToBookPage::class);



