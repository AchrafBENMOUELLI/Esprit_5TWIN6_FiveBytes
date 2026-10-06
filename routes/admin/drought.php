<?php

use App\Http\Controllers\Admin\DroughtController;
use Illuminate\Support\Facades\Route;

Route::prefix('drought')->name('drought.')->group(function () {
    Route::get('/restrictions', [DroughtController::class, 'indexRestrictions'])->name('restrictions.index');
    Route::get('/restrictions/create', [DroughtController::class, 'createRestriction'])->name('restrictions.create');
    Route::post('/restrictions', [DroughtController::class, 'storeRestriction'])->name('restrictions.store');
    Route::get('/restrictions/{restriction}/edit', [DroughtController::class, 'editRestriction'])->name('restrictions.edit');
    Route::put('/restrictions/{restriction}', [DroughtController::class, 'updateRestriction'])->name('restrictions.update');
    Route::delete('/restrictions/{restriction}', [DroughtController::class, 'destroyRestriction'])->name('restrictions.destroy');

    Route::get('/water-levels', [DroughtController::class, 'indexWaterLevels'])->name('water-levels.index');
    Route::get('/water-levels/create', [DroughtController::class, 'createWaterLevel'])->name('water-levels.create');
    Route::post('/water-levels', [DroughtController::class, 'storeWaterLevel'])->name('water-levels.store');

    Route::get('/consumption', [DroughtController::class, 'indexConsumption'])->name('consumption.index');
    Route::get('/consumption/create', [DroughtController::class, 'createConsumption'])->name('consumption.create');
    Route::post('/consumption', [DroughtController::class, 'storeConsumption'])->name('consumption.store');

    Route::get('/scheduled-cuts', [DroughtController::class, 'indexScheduledCuts'])->name('scheduled-cuts.index');
    Route::get('/scheduled-cuts/create', [DroughtController::class, 'createScheduledCut'])->name('scheduled-cuts.create');
    Route::post('/scheduled-cuts', [DroughtController::class, 'storeScheduledCut'])->name('scheduled-cuts.store');
});
