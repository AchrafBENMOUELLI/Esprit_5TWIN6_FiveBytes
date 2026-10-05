<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\Project\ProjectController;
use App\Http\Controllers\Front\Project\FundingController;

// Front - project routes (accessible aux citoyens et visiteurs)
Route::prefix('projets')->name('project.')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('index');
    Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
});

// Front - donation routes (nécessite authentification)
Route::middleware('auth')->prefix('projets')->name('project.')->group(function () {
    Route::get('/{projectId}/faire-un-don', [FundingController::class, 'simulateDonation'])->name('donate');
    Route::post('/don', [FundingController::class, 'storeDonation'])->name('donate.store');
});

// Front - my donations (nécessite authentification)
Route::middleware('auth')->prefix('mes-dons')->name('donations.')->group(function () {
    Route::get('/', [FundingController::class, 'myDonations'])->name('index');
});
