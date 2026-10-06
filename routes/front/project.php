<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\Project\ProjectController;
use App\Http\Controllers\Front\Project\FundingController;

/*
|--------------------------------------------------------------------------
| Front Project Routes
|--------------------------------------------------------------------------
|
| Routes publiques pour les citoyens et visiteurs
| Consultation des projets et système de dons
|
*/

// ============================================================================
// PROJECTS - Consultation Publique (Sans Authentification)
// ============================================================================
Route::prefix('projets')->name('projects.')->group(function () {
    // Liste des projets publics avec filtres
    Route::get('/', [ProjectController::class, 'index'])->name('index');
    
    // Détails d'un projet spécifique
    Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
});

// ============================================================================
// DONATIONS - Système de Dons (Nécessite Authentification)
// ============================================================================
Route::middleware('auth')->group(function () {
    
    // Simulation et enregistrement de dons
    Route::prefix('projets/{project}')->name('projects.')->group(function () {
        // Formulaire de don pour un projet spécifique
        Route::get('/faire-un-don', [FundingController::class, 'simulateDonation'])->name('donate');
        
        // Confirmation avant don (optionnel)
        Route::get('/confirmer-don', [FundingController::class, 'confirmDonation'])->name('donate.confirm');
    });
    
    // Enregistrement du don
    Route::post('/projets/don', [FundingController::class, 'storeDonation'])->name('projects.donate.store');
    
    // Historique des dons du citoyen connecté
    Route::prefix('mes-dons')->name('donations.')->group(function () {
        Route::get('/', [FundingController::class, 'myDonations'])->name('index');
        Route::get('/{funding}', [FundingController::class, 'showDonation'])->name('show');
        
        // Annuler un don en attente
        Route::delete('/{funding}/cancel', [FundingController::class, 'cancelDonation'])->name('cancel');
    });
});

// ============================================================================
// STATISTIQUES PUBLIQUES (Optionnel)
// ============================================================================
Route::prefix('statistiques')->name('stats.')->group(function () {
    // Statistiques globales des projets
    Route::get('/projets', [ProjectController::class, 'statistics'])->name('projects');
    
    // Impact des dons citoyens
    Route::get('/dons', [FundingController::class, 'donationStatistics'])->name('donations');
});
