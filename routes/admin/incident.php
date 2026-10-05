<?php

use App\Http\Controllers\Admin\IncidentController;
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
