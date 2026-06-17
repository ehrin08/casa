<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/manager/dashboard', function () {
        return view('manager.dashboard');
    })->middleware('role:manager')->name('manager.dashboard');

    Route::get('/therapist/dashboard', function () {
        return view('therapist.dashboard');
    })->middleware('role:therapist')->name('therapist.dashboard');

    Route::get('/customer/dashboard', function () {
        return view('customer.dashboard');
    })->middleware('role:customer')->name('customer.dashboard');
});
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
