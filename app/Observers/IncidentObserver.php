<?php

namespace App\Observers;

use App\Enums\IncidentStatut;
use App\Models\Incident\Incident;
use App\Models\Incident\IncidentStatusHistory;

class IncidentObserver
{
    /**
     * Handle the Incident "created" event.
     * Enregistre l'historique initial lors de la création d'un incident
     */
    public function created(Incident $incident): void
    {
        IncidentStatusHistory::create([
            'incident_id' => $incident->id,
            'ancien_statut' => null,
            'nouveau_statut' => $incident->statut instanceof IncidentStatut ? $incident->statut->value : $incident->statut,
            'modifie_par' => $incident->citoyen_id,
            'date_changement' => now(),
        ]);
    }

    /**
     * Handle the Incident "updated" event.
     * Enregistre l'historique lors d'un changement de statut
     */
    public function updated(Incident $incident): void
    {
        // Vérifie si le statut a changé
        if ($incident->isDirty('statut')) {
            $ancienStatut = $incident->getOriginal('statut');
            $nouveauStatut = $incident->statut;
            
            // Enregistre l'historique du changement de statut
            IncidentStatusHistory::create([
                'incident_id' => $incident->id,
                'ancien_statut' => $ancienStatut instanceof IncidentStatut ? $ancienStatut->value : $ancienStatut,
                'nouveau_statut' => $nouveauStatut instanceof IncidentStatut ? $nouveauStatut->value : $nouveauStatut,
                'modifie_par' => auth()->id() ?? $incident->citoyen_id,
                'date_changement' => now(),
            ]);

            // Gère automatiquement la date de résolution
            $this->handleDateResolution($incident);
        }
    }

    /**
     * Gère automatiquement la date de résolution selon le statut
     * - Si le statut passe à "resolu" : remplit date_resolution
     * - Si le statut revient en arrière : remet date_resolution à null
     */
    private function handleDateResolution(Incident $incident): void
    {
        $nouveauStatut = $incident->statut;
        $dateResolution = $incident->date_resolution;

        // Si le statut est "resolu" et date_resolution est null, on la remplit
        if ($nouveauStatut === IncidentStatut::Resolu && $dateResolution === null) {
            $incident->date_resolution = now();
            $incident->saveQuietly(); // saveQuietly pour éviter de redéclencher l'observer
        }
        
        // Si le statut n'est plus "resolu" et date_resolution est remplie, on la remet à null
        if ($nouveauStatut !== IncidentStatut::Resolu && $dateResolution !== null) {
            $incident->date_resolution = null;
            $incident->saveQuietly(); // saveQuietly pour éviter de redéclencher l'observer
        }
    }
}
