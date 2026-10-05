<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Project\ProjectController;
use App\Http\Controllers\Admin\Project\ContractorController;
use App\Http\Controllers\Admin\Project\ProjectPhaseController;
use App\Http\Controllers\Admin\Project\FundingController;
use App\Http\Controllers\Admin\Project\ProjectDocumentController;

/*
|--------------------------------------------------------------------------
| Admin Project Routes
|--------------------------------------------------------------------------
|
| Routes pour la gestion administrative des projets de rénovation
| Toutes les routes nécessitent l'authentification (middleware dans admin.php)
|
*/

// ============================================================================
// PROJECTS - Resource Controller
// ============================================================================
Route::resource('projects', ProjectController::class)->names([
    'index' => 'project.index',      // GET    /admin/projects
    'create' => 'project.create',    // GET    /admin/projects/create
    'store' => 'project.store',      // POST   /admin/projects
    'show' => 'project.show',        // GET    /admin/projects/{id}
    'edit' => 'project.edit',        // GET    /admin/projects/{id}/edit
    'update' => 'project.update',    // PUT    /admin/projects/{id}
    'destroy' => 'project.destroy',  // DELETE /admin/projects/{id}
]);

// Actions spéciales pour les projets
Route::prefix('projects')->name('project.')->group(function () {
    // Archiver un projet (soft delete si implémenté)
    Route::patch('/{project}/archive', [ProjectController::class, 'archive'])->name('archive');
    
    // Restaurer un projet archivé
    Route::patch('/{project}/restore', [ProjectController::class, 'restore'])->name('restore');
    
    // Changer le statut d'un projet rapidement
    Route::patch('/{project}/status', [ProjectController::class, 'updateStatus'])->name('update-status');
    
    // Dupliquer un projet
    Route::post('/{project}/duplicate', [ProjectController::class, 'duplicate'])->name('duplicate');
    
    // Export PDF/Excel d'un projet
    Route::get('/{project}/export', [ProjectController::class, 'export'])->name('export');
});

// ============================================================================
// CONTRACTORS - Resource Controller
// ============================================================================
Route::resource('contractors', ContractorController::class)->names([
    'index' => 'contractor.index',      // GET    /admin/contractors
    'create' => 'contractor.create',    // GET    /admin/contractors/create
    'store' => 'contractor.store',      // POST   /admin/contractors
    'show' => 'contractor.show',        // GET    /admin/contractors/{id}
    'edit' => 'contractor.edit',        // GET    /admin/contractors/{id}/edit
    'update' => 'contractor.update',    // PUT    /admin/contractors/{id}
    'destroy' => 'contractor.destroy',  // DELETE /admin/contractors/{id}
]);

// ============================================================================
// PROJECT PHASES - Routes Imbriquées
// ============================================================================
// Liste et création de phases pour un projet spécifique
Route::prefix('projects/{project}')->name('project.')->group(function () {
    Route::prefix('phases')->name('phase.')->group(function () {
        Route::get('/', [ProjectPhaseController::class, 'index'])->name('index');
        Route::get('/create', [ProjectPhaseController::class, 'create'])->name('create');
        Route::post('/', [ProjectPhaseController::class, 'store'])->name('store');
    });
});

// Gestion individuelle des phases (indépendamment du projet)
Route::prefix('phases')->name('phase.')->group(function () {
    Route::get('/{phase}', [ProjectPhaseController::class, 'show'])->name('show');
    Route::get('/{phase}/edit', [ProjectPhaseController::class, 'edit'])->name('edit');
    Route::put('/{phase}', [ProjectPhaseController::class, 'update'])->name('update');
    Route::delete('/{phase}', [ProjectPhaseController::class, 'destroy'])->name('destroy');
});

// ============================================================================
// FUNDINGS - Routes Imbriquées
// ============================================================================
// Liste et création de financements pour un projet spécifique
Route::prefix('projects/{project}')->name('project.')->group(function () {
    Route::prefix('fundings')->name('funding.')->group(function () {
        Route::get('/', [FundingController::class, 'index'])->name('index');
        Route::get('/create', [FundingController::class, 'create'])->name('create');
        Route::post('/', [FundingController::class, 'store'])->name('store');
    });
});

// Gestion individuelle des financements
Route::prefix('fundings')->name('funding.')->group(function () {
    Route::get('/{funding}', [FundingController::class, 'show'])->name('show');
    Route::get('/{funding}/edit', [FundingController::class, 'edit'])->name('edit');
    Route::put('/{funding}', [FundingController::class, 'update'])->name('update');
    Route::delete('/{funding}', [FundingController::class, 'destroy'])->name('destroy');
    
    // Approuver/rejeter un financement (pour les dons citoyens)
    Route::patch('/{funding}/approve', [FundingController::class, 'approve'])->name('approve');
    Route::patch('/{funding}/reject', [FundingController::class, 'reject'])->name('reject');
});

// ============================================================================
// DOCUMENTS - Routes Imbriquées avec Upload
// ============================================================================
// Liste et création de documents pour un projet spécifique
Route::prefix('projects/{project}')->name('project.')->group(function () {
    Route::prefix('documents')->name('document.')->group(function () {
        Route::get('/', [ProjectDocumentController::class, 'index'])->name('index');
        Route::get('/create', [ProjectDocumentController::class, 'create'])->name('create');
        Route::post('/', [ProjectDocumentController::class, 'store'])->name('store'); // Upload
    });
});

// Gestion individuelle des documents
Route::prefix('documents')->name('document.')->group(function () {
    Route::get('/{document}', [ProjectDocumentController::class, 'show'])->name('show');
    Route::get('/{document}/edit', [ProjectDocumentController::class, 'edit'])->name('edit');
    Route::put('/{document}', [ProjectDocumentController::class, 'update'])->name('update');
    Route::delete('/{document}', [ProjectDocumentController::class, 'destroy'])->name('destroy');
    
    // Téléchargement de document
    Route::get('/{document}/download', [ProjectDocumentController::class, 'download'])->name('download');
    
    // Prévisualisation de document (si applicable)
    Route::get('/{document}/preview', [ProjectDocumentController::class, 'preview'])->name('preview');
});
