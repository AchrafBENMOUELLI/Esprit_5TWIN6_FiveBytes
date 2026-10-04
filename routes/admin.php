<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->prefix('admin')->name('admin.')->group(function () {
    require __DIR__ . '/admin/infrastructure.php';
    require __DIR__ . '/admin/incident.php';
    require __DIR__ . '/admin/quality.php';
    require __DIR__ . '/admin/drought.php';
    require __DIR__ . '/admin/project.php';
});
