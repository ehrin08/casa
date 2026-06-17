<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Manager\ServiceController as ManagerServiceController;
use App\Http\Controllers\Customer\ServiceController as CustomerServiceController;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    // Manager Routes
    Route::middleware('role:manager')->prefix('manager')->name('manager.')->group(function () {
        Route::get('/dashboard', function () {
            return view('manager.dashboard');
        })->name('dashboard');
        
        Route::resource('services', ManagerServiceController::class);
        Route::resource('therapists', App\Http\Controllers\Manager\TherapistController::class);
    });

    // Therapist Routes
    Route::middleware('role:therapist')->prefix('therapist')->name('therapist.')->group(function () {
        Route::get('/dashboard', function () {
            return view('therapist.dashboard');
        })->name('dashboard');
    });

    // Customer Routes
    Route::middleware('role:customer')->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', function () {
            return view('customer.dashboard');
        })->name('dashboard');
        
        Route::get('services', [CustomerServiceController::class, 'index'])->name('services.index');
    });
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
