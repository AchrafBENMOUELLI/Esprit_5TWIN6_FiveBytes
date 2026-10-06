<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncidentCommentRequest;
use App\Models\Incident\Incident;
use App\Models\Incident\IncidentComment;
use Illuminate\Support\Facades\DB;

class IncidentCommentController extends Controller
{
    /**
     * Store a newly created comment for an incident.
     */
    public function store(StoreIncidentCommentRequest $request, Incident $incident)
    {
        // Vérifier que l'utilisateur peut voir cet incident
        $this->authorize('view', $incident);
        $this->authorize('create', IncidentComment::class);

        try {
            DB::beginTransaction();

            $data = $request->validated();
            $data['user_id'] = auth()->id();
            $data['incident_id'] = $incident->id;
            
            // S'assurer que interne est défini (false par défaut)
            if (!isset($data['interne'])) {
                $data['interne'] = false;
            }

            IncidentComment::create($data);

            DB::commit();

            return back()->with('success', 'Votre commentaire a été ajouté avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', "Une erreur est survenue lors de l'ajout du commentaire : {$e->getMessage()}");
        }
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(IncidentComment $comment)
    {
        $this->authorize('delete', $comment);

        try {
            DB::beginTransaction();

            $comment->delete();

            DB::commit();

            return back()->with('success', 'Le commentaire a été supprimé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', "Une erreur est survenue lors de la suppression du commentaire : {$e->getMessage()}");
        }
    }
}
