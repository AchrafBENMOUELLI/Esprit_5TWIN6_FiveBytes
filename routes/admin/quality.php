<?php

use App\Http\Controllers\Quality\QualityAlertController;
use App\Http\Controllers\Quality\ThresholdController;
use App\Http\Controllers\Quality\WaterParameterController;
use App\Http\Controllers\Quality\WaterSampleController;
use Illuminate\Support\Facades\Route;

Route::prefix('quality')->name('quality.')->group(function () {
    // Routes pour les échantillons d'eau
    Route::resource('samples', WaterSampleController::class);
    
    // Routes pour les paramètres d'un échantillon
    Route::get('samples/{sample}/parameters', [WaterParameterController::class, 'index'])
        ->name('samples.parameters.index');
    
    // Route pour afficher un paramètre individuel
    Route::get('parameters/{parameter}', [WaterParameterController::class, 'show'])
        ->name('parameters.show');

    // Routes pour les seuils
    Route::resource('thresholds', ThresholdController::class);

    // Routes pour les alertes qualité
    Route::resource('alerts', QualityAlertController::class)
        ->only(['index', 'show', 'update', 'destroy']);
    
    // Routes spéciales pour les alertes
    Route::post('alerts/{alert}/resolve', [QualityAlertController::class, 'resolve'])
        ->name('alerts.resolve');
    Route::post('alerts/{alert}/publish', [QualityAlertController::class, 'publish'])
        ->name('alerts.publish');
});
