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
        Route::resource('therapist-availabilities', App\Http\Controllers\Manager\TherapistAvailabilityController::class);
        Route::resource('bookings', App\Http\Controllers\Manager\BookingController::class);
    });

    // Therapist Routes
    Route::middleware('role:therapist')->prefix('therapist')->name('therapist.')->group(function () {
        Route::get('/dashboard', function () {
            return view('therapist.dashboard');
        })->name('dashboard');

        Route::get('my-availability', [App\Http\Controllers\Therapist\AvailabilityController::class, 'index'])->name('availability.index');
        
        Route::resource('bookings', App\Http\Controllers\Therapist\BookingController::class)->only(['index', 'create', 'store', 'show']);
    });

    // Customer Routes
    Route::middleware('role:customer')->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', function () {
            return view('customer.dashboard');
        })->name('dashboard');
        
        Route::get('services', [CustomerServiceController::class, 'index'])->name('services.index');
        
        Route::patch('bookings/{booking}/cancel', [App\Http\Controllers\Customer\BookingController::class, 'cancel'])->name('bookings.cancel');
        Route::resource('bookings', App\Http\Controllers\Customer\BookingController::class)->only(['index', 'create', 'store', 'show']);
    });
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
