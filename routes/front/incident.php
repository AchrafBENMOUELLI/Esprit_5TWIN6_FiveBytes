<?php

use App\Http\Controllers\Front\IncidentController;
use Illuminate\Support\Facades\Route;

// Front - Gestion des incidents citoyens
Route::resource('incidents', IncidentController::class)->names([
    'index' => 'incidents.index',
    'create' => 'incidents.create',
    'store' => 'incidents.store',
    'show' => 'incidents.show',
    'edit' => 'incidents.edit',
    'update' => 'incidents.update',
    'destroy' => 'incidents.destroy',
]);
