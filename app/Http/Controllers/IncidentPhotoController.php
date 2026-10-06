<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncidentPhotoRequest;
use App\Models\Incident\Incident;
use App\Models\Incident\IncidentPhoto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class IncidentPhotoController extends Controller
{
    /**
     * Store newly uploaded photos for an incident.
     */
    public function store(StoreIncidentPhotoRequest $request, Incident $incident)
    {
        // Autorisation : un citoyen ne peut ajouter des photos qu'à ses propres incidents au statut "nouveau"
        // Les Gestionnaires et Admins peuvent ajouter des photos à tous les incidents
        $this->authorize('update', $incident);

        try {
            DB::beginTransaction();

            $photosEnregistrees = 0;

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    // Stocker le fichier dans storage/app/public/incidents/{incident_id}/
                    $path = $photo->store("incidents/{$incident->id}", 'public');

                    // Créer l'enregistrement en base de données
                    IncidentPhoto::create([
                        'incident_id' => $incident->id,
                        'chemin_fichier' => $path,
                        'legende' => $request->legende,
                    ]);

                    $photosEnregistrees++;
                }
            }

            DB::commit();

            $message = $photosEnregistrees > 1
                ? "{$photosEnregistrees} photos ont été ajoutées avec succès."
                : "La photo a été ajoutée avec succès.";

            return back()->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', "Une erreur est survenue lors de l'ajout des photos : {$e->getMessage()}");
        }
    }

    /**
     * Remove the specified photo from storage and database.
     */
    public function destroy(IncidentPhoto $photo)
    {
        // Autorisation via la policy de l'incident parent
        $this->authorize('update', $photo->incident);

        try {
            DB::beginTransaction();

            // Supprimer le fichier du disque
            if (Storage::disk('public')->exists($photo->chemin_fichier)) {
                Storage::disk('public')->delete($photo->chemin_fichier);
            }

            // Supprimer l'enregistrement de la base de données
            $photo->delete();

            DB::commit();

            return back()->with('success', 'La photo a été supprimée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', "Une erreur est survenue lors de la suppression de la photo : {$e->getMessage()}");
        }
    }
}
