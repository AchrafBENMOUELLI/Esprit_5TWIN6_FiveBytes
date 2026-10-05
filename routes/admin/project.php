<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Project\ProjectController;
use App\Http\Controllers\Admin\Project\ContractorController;
use App\Http\Controllers\Admin\Project\ProjectPhaseController;
use App\Http\Controllers\Admin\Project\FundingController;
use App\Http\Controllers\Admin\Project\ProjectDocumentController;

// Routes admin pour les projets (resource controller)
Route::resource('projects', ProjectController::class)->names([
    'index' => 'project.index',
    'create' => 'project.create',
    'store' => 'project.store',
    'show' => 'project.show',
    'edit' => 'project.edit',
    'update' => 'project.update',
    'destroy' => 'project.destroy',
]);

// Routes admin pour les entrepreneurs (resource controller)
Route::resource('contractors', ContractorController::class)->names([
    'index' => 'contractor.index',
    'create' => 'contractor.create',
    'store' => 'contractor.store',
    'show' => 'contractor.show',
    'edit' => 'contractor.edit',
    'update' => 'contractor.update',
    'destroy' => 'contractor.destroy',
]);

// Routes pour les phases de projet
Route::prefix('projects/{projectId}/phases')->name('phase.')->group(function () {
    Route::get('/', [ProjectPhaseController::class, 'index'])->name('index');
    Route::get('/create', [ProjectPhaseController::class, 'create'])->name('create');
});

Route::prefix('phases')->name('phase.')->group(function () {
    Route::post('/', [ProjectPhaseController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [ProjectPhaseController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ProjectPhaseController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProjectPhaseController::class, 'destroy'])->name('destroy');
});

// Routes pour les financements
Route::prefix('projects/{projectId}/fundings')->name('funding.')->group(function () {
    Route::get('/', [FundingController::class, 'index'])->name('index');
    Route::get('/create', [FundingController::class, 'create'])->name('create');
});

Route::prefix('fundings')->name('funding.')->group(function () {
    Route::post('/', [FundingController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [FundingController::class, 'edit'])->name('edit');
    Route::put('/{id}', [FundingController::class, 'update'])->name('update');
    Route::delete('/{id}', [FundingController::class, 'destroy'])->name('destroy');
});

// Routes pour les documents
Route::prefix('projects/{projectId}/documents')->name('document.')->group(function () {
    Route::get('/', [ProjectDocumentController::class, 'index'])->name('index');
    Route::get('/create', [ProjectDocumentController::class, 'create'])->name('create');
});

Route::prefix('documents')->name('document.')->group(function () {
    Route::post('/', [ProjectDocumentController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [ProjectDocumentController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ProjectDocumentController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProjectDocumentController::class, 'destroy'])->name('destroy');
    Route::get('/{id}/download', [ProjectDocumentController::class, 'download'])->name('download');
});
