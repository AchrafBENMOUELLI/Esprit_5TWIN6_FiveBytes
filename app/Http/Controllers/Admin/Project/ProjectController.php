<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project\Project;
use App\Models\Infrastructure\Zone;
use App\Models\Infrastructure\Infrastructure;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Constructeur avec middleware d'authentification
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Afficher la liste paginée des projets avec filtres et recherche.
     */
    public function index(Request $request)
    {
        $query = Project::with(['zone', 'infrastructure', 'responsable']);

        // Recherche par titre ou description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtre par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Filtre par type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filtre par zone
        if ($request->filled('zone_id')) {
            $query->where('zone_id', $request->zone_id);
        }

        $projects = $query->orderBy('date_debut', 'desc')->paginate(15);
        $zones = Zone::all();

        return view('components.project.admin.index', compact('projects', 'zones'));
    }

    /**
     * Afficher le formulaire de création d'un nouveau projet.
     */
    public function create()
    {
        $zones = Zone::all();
        $infrastructures = Infrastructure::all();
        $gestionnaires = User::where('role', UserRole::Gestionnaire)->get();

        return view('components.project.admin.create', compact('zones', 'infrastructures', 'gestionnaires'));
    }

    /**
     * Enregistrer un nouveau projet dans la base de données.
     */
    public function store(StoreProjectRequest $request)
    {
        $project = Project::create($request->validated());

        return redirect()
            ->route('admin.project.index')
            ->with('success', 'Le projet "' . $project->titre . '" a été créé avec succès.');
    }

    /**
     * Afficher les détails complets d'un projet avec toutes ses relations.
     */
    public function show(Project $project)
    {
        $project->load([
            'zone',
            'infrastructure',
            'responsable',
            'projectPhases.contractor',
            'fundings.donateur',
            'projectDocuments'
        ]);

        return view('components.project.admin.show', compact('project'));
    }

    /**
     * Afficher le formulaire d'édition d'un projet existant.
     */
    public function edit(Project $project)
    {
        $zones = Zone::all();
        $infrastructures = Infrastructure::all();
        $gestionnaires = User::where('role', UserRole::Gestionnaire)->get();

        return view('components.project.admin.edit', compact('project', 'zones', 'infrastructures', 'gestionnaires'));
    }

    /**
     * Mettre à jour un projet existant dans la base de données.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->validated());

        return redirect()
            ->route('admin.project.show', $project)
            ->with('success', 'Le projet "' . $project->titre . '" a été mis à jour avec succès.');
    }

    /**
     * Supprimer un projet de la base de données.
     * Vérifie les dépendances avant suppression.
     */
    public function destroy(Project $project)
    {
        // Vérifier si le projet a des dépendances
        $phasesCount = $project->projectPhases()->count();
        $fundingsCount = $project->fundings()->count();
        $documentsCount = $project->projectDocuments()->count();

        if ($phasesCount > 0 || $fundingsCount > 0 || $documentsCount > 0) {
            return redirect()
                ->route('admin.project.show', $project)
                ->with('error', 'Impossible de supprimer ce projet car il contient des phases (' . $phasesCount . '), des financements (' . $fundingsCount . ') ou des documents (' . $documentsCount . '). Veuillez les supprimer d\'abord.');
        }

        $titre = $project->titre;
        $project->delete();

        return redirect()
            ->route('admin.project.index')
            ->with('success', 'Le projet "' . $titre . '" a été supprimé avec succès.');
    }
}
