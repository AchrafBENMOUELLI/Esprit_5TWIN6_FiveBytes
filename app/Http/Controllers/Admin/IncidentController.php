<?php

namespace App\Http\Controllers\Admin;

use App\Enums\IncidentStatut;
use App\Enums\IncidentType;
use App\Enums\IncidentUrgence;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIncidentRequest;
use App\Http\Requests\UpdateIncidentRequest;
use App\Models\Incident\Incident;
use App\Models\Incident\IncidentPhoto;
use App\Models\Infrastructure\Infrastructure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncidentController extends Controller
{
    /**
     * Display a listing of the incidents.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Incident::class);

        // Construction de la requête avec eager loading pour éviter N+1
        $query = Incident::with(['citoyen', 'technicien', 'infrastructure.zone']);

        // Filtre par recherche (référence, description, nom du citoyen)
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

        return view('incident.admin.index', [
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

        // Récupérer la liste des techniciens (Gestionnaires et Admins)
        $techniciens = User::whereIn('role', [UserRole::Gestionnaire, UserRole::Admin])
            ->orderBy('name')
            ->get();

        // Récupérer la liste des citoyens
        $citoyens = User::where('role', UserRole::Citoyen)
            ->orderBy('name')
            ->get();

        return view('incident.admin.create', [
            'infrastructures' => $infrastructures,
            'techniciens' => $techniciens,
            'citoyens' => $citoyens,
            'statuts' => IncidentStatut::cases(),
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

            $incident = Incident::create($request->validated());

            // Gérer l'upload des photos si présentes
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $path = $photo->store("incidents/{$incident->id}", 'public');
                    
                    IncidentPhoto::create([
                        'incident_id' => $incident->id,
                        'chemin_fichier' => $path,
                        'legende' => $request->legende,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.incidents.show', $incident)
                ->with('success', "L'incident {$incident->reference} a été créé avec succès.");
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', "Une erreur est survenue lors de la création de l'incident : {$e->getMessage()}");
        }
    }

    /**
     * Display the specified incident.
     */
    public function show(Incident $incident)
    {
        $this->authorize('view', $incident);

        // Charger les relations pour éviter N+1
        $incident->load(['citoyen', 'technicien', 'infrastructure.zone', 'parent', 'doublons', 'photos', 'comments.auteur', 'statusHistory.modificateur']);

        return view('incident.admin.show', [
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

        // Récupérer la liste des techniciens (Gestionnaires et Admins)
        $techniciens = User::whereIn('role', [UserRole::Gestionnaire, UserRole::Admin])
            ->orderBy('name')
            ->get();

        // Récupérer la liste des citoyens
        $citoyens = User::where('role', UserRole::Citoyen)
            ->orderBy('name')
            ->get();

        // Récupérer les incidents potentiels parents (pour les doublons)
        $incidentsParents = Incident::where('id', '!=', $incident->id)
            ->whereNull('incident_parent_id')
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        return view('incident.admin.edit', [
            'incident' => $incident,
            'infrastructures' => $infrastructures,
            'techniciens' => $techniciens,
            'citoyens' => $citoyens,
            'incidentsParents' => $incidentsParents,
            'statuts' => IncidentStatut::cases(),
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

            // La gestion de date_resolution est maintenant automatique via l'Observer
            $incident->update($data);

            DB::commit();

            return redirect()
                ->route('admin.incidents.show', $incident)
                ->with('success', "L'incident {$incident->reference} a été modifié avec succès.");
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', "Une erreur est survenue lors de la modification de l'incident : {$e->getMessage()}");
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
                ->route('admin.incidents.index')
                ->with('success', "L'incident {$reference} a été supprimé avec succès.");
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', "Une erreur est survenue lors de la suppression de l'incident : {$e->getMessage()}");
        }
    }
}
