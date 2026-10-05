<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\Project\ProjectController;

// Front - project routes (accessible aux citoyens et visiteurs)
Route::prefix('projets')->name('project.')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('index');
    Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
});
