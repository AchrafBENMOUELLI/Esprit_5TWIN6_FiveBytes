<?php

use App\Http\Controllers\Front\DroughtController;
use Illuminate\Support\Facades\Route;

// Front - drought routes
Route::prefix('drought')->name('drought.')->group(function () {
    // Public drought dashboard
    Route::get('/dashboard', [DroughtController::class, 'dashboard'])->name('dashboard');
    
    // Zone specific alerts
    Route::get('/zone/{zone}/alerts', [DroughtController::class, 'zoneAlerts'])->name('zone.alerts');
    
    // Scheduled cuts calendar
    Route::get('/scheduled-cuts', [DroughtController::class, 'scheduledCuts'])->name('scheduled-cuts');
    
    // Subscriptions management
    Route::get('/subscriptions', [DroughtController::class, 'mySubscriptions'])->name('subscriptions');
    Route::post('/subscriptions', [DroughtController::class, 'storeSubscription'])->name('subscriptions.store');
    Route::patch('/subscriptions/{subscription}/toggle', [DroughtController::class, 'toggleSubscription'])->name('subscriptions.toggle');
    Route::delete('/subscriptions/{subscription}', [DroughtController::class, 'destroySubscription'])->name('subscriptions.destroy');
});
