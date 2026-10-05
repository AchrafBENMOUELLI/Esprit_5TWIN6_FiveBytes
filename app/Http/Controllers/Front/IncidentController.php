<?php

namespace App\Http\Controllers\Front;

use App\Enums\IncidentStatut;
use App\Enums\IncidentType;
use App\Enums\IncidentUrgence;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIncidentRequest;
use App\Http\Requests\UpdateIncidentRequest;
use App\Models\Incident\Incident;
use App\Models\Infrastructure\Infrastructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncidentController extends Controller
{
    /**
     * Display a listing of the user's incidents.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Incident::class);

        // Récupérer uniquement les incidents du citoyen connecté
        $query = Incident::with(['technicien', 'infrastructure'])
            ->where('citoyen_id', auth()->id());

        // Filtre par recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->search($search);
        }

        // Filtre par statut
        if ($request->filled('statut')) {
            $query->parStatut($request->statut);
        }

        // Filtre par urgence
        if ($request->filled('urgence')) {
            $query->parUrgence($request->urgence);
        }

        // Filtre par type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Tri par défaut : les plus récents d'abord
        $query->orderBy('created_at', 'desc');

        // Pagination
        $incidents = $query->paginate(10)->withQueryString();

        return view('front.incident.index', [
            'incidents' => $incidents,
            'statuts' => IncidentStatut::cases(),
            'urgences' => IncidentUrgence::cases(),
            'types' => IncidentType::cases(),
            'filters' => $request->only(['search', 'statut', 'urgence', 'type']),
        ]);
    }

    /**
     * Show the form for creating a new incident.
     */
    public function create()
    {
        $this->authorize('create', Incident::class);

        // Récupérer la liste des infrastructures
        $infrastructures = Infrastructure::orderBy('nom')->get();

        return view('front.incident.create', [
            'infrastructures' => $infrastructures,
            'urgences' => IncidentUrgence::cases(),
            'types' => IncidentType::cases(),
        ]);
    }

    /**
     * Store a newly created incident in storage.
     */
    public function store(StoreIncidentRequest $request)
    {
        $this->authorize('create', Incident::class);

        try {
            DB::beginTransaction();

            $data = $request->validated();
            
            // Forcer le citoyen_id à l'utilisateur connecté (sécurité)
            $data['citoyen_id'] = auth()->id();
            
            // Forcer le statut à "nouveau" pour les citoyens
            $data['statut'] = IncidentStatut::Nouveau;

            $incident = Incident::create($data);

            DB::commit();

            return redirect()
                ->route('front.incidents.show', $incident)
                ->with('success', "Votre incident {$incident->reference} a été enregistré avec succès. Nous le traiterons dans les plus brefs délais.");
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', "Une erreur est survenue lors de l'enregistrement de votre incident : {$e->getMessage()}");
        }
    }

    /**
     * Display the specified incident.
     */
    public function show(Incident $incident)
    {
        $this->authorize('view', $incident);

        // Charger les relations
        $incident->load(['technicien', 'infrastructure', 'parent', 'doublons']);

        return view('front.incident.show', [
            'incident' => $incident,
        ]);
    }

    /**
     * Show the form for editing the specified incident.
     */
    public function edit(Incident $incident)
    {
        $this->authorize('update', $incident);

        // Récupérer la liste des infrastructures
        $infrastructures = Infrastructure::orderBy('nom')->get();

        return view('front.incident.edit', [
            'incident' => $incident,
            'infrastructures' => $infrastructures,
            'urgences' => IncidentUrgence::cases(),
            'types' => IncidentType::cases(),
        ]);
    }

    /**
     * Update the specified incident in storage.
     */
    public function update(UpdateIncidentRequest $request, Incident $incident)
    {
        $this->authorize('update', $incident);

        try {
            DB::beginTransaction();

            $data = $request->validated();
            
            // Le citoyen ne peut jamais modifier ces champs (sécurité supplémentaire)
            unset($data['citoyen_id']);
            unset($data['technicien_id']);
            unset($data['statut']);
            unset($data['incident_parent_id']);
            unset($data['date_resolution']);

            $incident->update($data);

            DB::commit();

            return redirect()
                ->route('front.incidents.show', $incident)
                ->with('success', "Votre incident {$incident->reference} a été modifié avec succès.");
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', "Une erreur est survenue lors de la modification de votre incident : {$e->getMessage()}");
        }
    }

    /**
     * Remove the specified incident from storage.
     */
    public function destroy(Incident $incident)
    {
        $this->authorize('delete', $incident);

        try {
            DB::beginTransaction();

            $reference = $incident->reference;
            $incident->delete();

            DB::commit();

            return redirect()
                ->route('front.incidents.index')
                ->with('success', "Votre incident {$reference} a été supprimé avec succès.");
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', "Une erreur est survenue lors de la suppression de votre incident : {$e->getMessage()}");
        }
    }
}
