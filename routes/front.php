<?php

use Illuminate\Support\Facades\Route;

// Route d'accueil pour les citoyens (page d'accueil front-office)
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/front', function () {
        return view('front-home');
    })->name('front.home');
});

Route::middleware(['web', 'auth'])->prefix('front')->name('front.')->group(function () {
    require __DIR__ . '/front/infrastructure.php';
    require __DIR__ . '/front/incident.php';
    require __DIR__ . '/front/quality.php';
    require __DIR__ . '/front/drought.php';
    require __DIR__ . '/front/project.php';
});
