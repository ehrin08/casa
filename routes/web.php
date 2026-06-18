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
        
        // Promotions
        Route::prefix('promotions')->name('promotions.')->group(function() {
            Route::get('/', [\App\Http\Controllers\Manager\PromotionController::class, 'index'])->name('index');
            Route::get('/rules', [\App\Http\Controllers\Manager\PromotionController::class, 'rules'])->name('rules');
            Route::get('/rules/create', [\App\Http\Controllers\Manager\PromotionController::class, 'createRule'])->name('rules.create');
            Route::post('/rules', [\App\Http\Controllers\Manager\PromotionController::class, 'storeRule'])->name('rules.store');
            Route::get('/rules/{promotionRule}/edit', [\App\Http\Controllers\Manager\PromotionController::class, 'editRule'])->name('rules.edit');
            Route::patch('/rules/{promotionRule}', [\App\Http\Controllers\Manager\PromotionController::class, 'updateRule'])->name('rules.update');
            Route::delete('/rules/{promotionRule}', [\App\Http\Controllers\Manager\PromotionController::class, 'destroyRule'])->name('rules.destroy');
            Route::post('/generate', [\App\Http\Controllers\Manager\PromotionController::class, 'generate'])->name('generate');
            Route::get('/customer-promotions', [\App\Http\Controllers\Manager\PromotionController::class, 'customerPromotions'])->name('customer-promotions');
            Route::get('/simulator', [\App\Http\Controllers\Manager\PromotionController::class, 'simulator'])->name('simulator');
            Route::post('/simulator', [\App\Http\Controllers\Manager\PromotionController::class, 'runSimulation'])->name('simulate');
        });

        Route::resource('services', ManagerServiceController::class);
        Route::resource('therapists', \App\Http\Controllers\Manager\TherapistController::class);
        Route::resource('therapist-availabilities', \App\Http\Controllers\Manager\TherapistAvailabilityController::class);
        Route::resource('bookings', \App\Http\Controllers\Manager\BookingController::class);
        Route::get('transactions', [\App\Http\Controllers\Manager\TransactionController::class, 'index'])->name('transactions.index');
        Route::get('transactions/{transaction}', [\App\Http\Controllers\Manager\TransactionController::class, 'show'])->name('transactions.show');
        Route::patch('transactions/{transaction}/status', [\App\Http\Controllers\Manager\TransactionController::class, 'updateStatus'])->name('transactions.updateStatus');
        Route::post('bookings/{booking}/create-transaction', [\App\Http\Controllers\Manager\TransactionController::class, 'createFromBooking'])->name('transactions.createFromBooking');
        Route::get('transactions/{transaction}/receipt', [\App\Http\Controllers\Manager\TransactionController::class, 'receipt'])->name('transactions.receipt');

        // Commissions
        Route::get('commissions/report', [\App\Http\Controllers\Manager\CommissionController::class, 'report'])->name('commissions.report');
        Route::get('commissions/{commission}/pdf', [\App\Http\Controllers\Manager\CommissionController::class, 'pdf'])->name('commissions.pdf');
        Route::patch('commissions/{commission}/mark-paid', [\App\Http\Controllers\Manager\CommissionController::class, 'markPaid'])->name('commissions.markPaid');
        Route::patch('commissions/{commission}/void', [\App\Http\Controllers\Manager\CommissionController::class, 'void'])->name('commissions.void');
        Route::resource('commissions', \App\Http\Controllers\Manager\CommissionController::class)->only(['index', 'show']);
    });

    // Therapist Routes
    Route::middleware('role:therapist')->prefix('therapist')->name('therapist.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Therapist\DashboardController::class, 'index'])->name('dashboard');

        Route::get('my-availability', [\App\Http\Controllers\Therapist\AvailabilityController::class, 'index'])->name('availability.index');
        Route::resource('bookings', \App\Http\Controllers\Therapist\BookingController::class)->only(['index', 'create', 'store', 'show']);

        // Commissions
        Route::get('commissions/report', [\App\Http\Controllers\Therapist\CommissionController::class, 'report'])->name('commissions.report');
        Route::resource('commissions', \App\Http\Controllers\Therapist\CommissionController::class)->only(['index', 'show']);
    });

    // Customer Routes
    Route::middleware('role:customer')->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/promotions', [\App\Http\Controllers\Customer\PromotionController::class, 'index'])->name('promotions.index');

        Route::get('services', [CustomerServiceController::class, 'index'])->name('services.index');
        
        Route::patch('bookings/{booking}/cancel', [App\Http\Controllers\Customer\BookingController::class, 'cancel'])->name('bookings.cancel');
        Route::resource('bookings', App\Http\Controllers\Customer\BookingController::class)->only(['index', 'create', 'store', 'show']);
        Route::get('transactions', [\App\Http\Controllers\Customer\TransactionController::class, 'index'])->name('transactions.index');
        Route::get('transactions/{transaction}', [\App\Http\Controllers\Customer\TransactionController::class, 'show'])->name('transactions.show');
        Route::get('transactions/{transaction}/receipt', [\App\Http\Controllers\Customer\TransactionController::class, 'receipt'])->name('transactions.receipt');
    });
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
