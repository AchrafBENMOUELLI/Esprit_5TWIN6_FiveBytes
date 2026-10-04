<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->prefix('front')->name('front.')->group(function () {
    require __DIR__ . '/front/infrastructure.php';
    require __DIR__ . '/front/incident.php';
    require __DIR__ . '/front/quality.php';
    require __DIR__ . '/front/drought.php';
    require __DIR__ . '/front/project.php';
});
