<?php

use App\Livewire\AboutPage;
use App\Livewire\ContactPage;
use App\Livewire\RequestPage;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->name('public.')->group(function () {
    Route::get('/', AboutPage::class)->name('home');
    Route::get('/about', AboutPage::class)->name('about');
    Route::get('/request', RequestPage::class)->name('request');
    Route::get('/contact', ContactPage::class)->name('contact');
});
