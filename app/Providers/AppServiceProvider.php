<?php

namespace App\Providers;

use App\Models\Incident\Incident;
use App\Observers\IncidentObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Enregistre l'observer pour l'historique automatique des changements de statut
        Incident::observe(IncidentObserver::class);
    }
}
