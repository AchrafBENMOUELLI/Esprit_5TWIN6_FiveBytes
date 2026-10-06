<?php

use App\Http\Controllers\Admin\IncidentController;
use App\Http\Controllers\IncidentPhotoController;
use App\Http\Controllers\IncidentCommentController;
use Illuminate\Support\Facades\Route;

// Admin - Gestion des incidents (réservé aux Gestionnaires et Admins)
Route::resource('incidents', IncidentController::class)->names([
    'index' => 'incidents.index',
    'create' => 'incidents.create',
    'store' => 'incidents.store',
    'show' => 'incidents.show',
    'edit' => 'incidents.edit',
    'update' => 'incidents.update',
    'destroy' => 'incidents.destroy',
]);

// Routes pour la gestion des photos d'incidents
Route::post('incidents/{incident}/photos', [IncidentPhotoController::class, 'store'])
    ->name('incidents.photos.store');
Route::delete('incidents/photos/{photo}', [IncidentPhotoController::class, 'destroy'])
    ->name('incidents.photos.destroy');

// Routes pour la gestion des commentaires d'incidents
Route::post('incidents/{incident}/comments', [IncidentCommentController::class, 'store'])
    ->name('incidents.comments.store');
Route::delete('incidents/comments/{comment}', [IncidentCommentController::class, 'destroy'])
    ->name('incidents.comments.destroy');
