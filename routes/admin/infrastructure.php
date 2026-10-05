<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Infrastructure\ZoneController;
use App\Http\Controllers\Infrastructure\InfrastructureController;
use App\Http\Controllers\Infrastructure\MaintenanceController;

Route::prefix('infrastructure')->name('infrastructure.')->group(function () {
    Route::resource('zones', ZoneController::class);
    Route::resource('infrastructures', InfrastructureController::class);
    Route::resource('maintenances', MaintenanceController::class);
});
