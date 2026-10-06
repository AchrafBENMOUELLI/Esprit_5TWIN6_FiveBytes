<?php

namespace App\Http\Controllers\Front\Project;

use App\Http\Controllers\Controller;
use App\Models\Project\Project;
use App\Models\Infrastructure\Zone;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects for citizens.
     * Affiche uniquement les projets non annulés avec transparence budgétaire.
     */
    public function index(Request $request)
    {
        $query = Project::with(['zone', 'infrastructure', 'responsable'])
            ->where('statut', '!=', 'annulé'); // Ne pas afficher les projets annulés
        
        // Filtres
        if ($request->filled('zone_id')) {
            $query->where('zone_id', $request->zone_id);
        }
        
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        
        $projects = $query->orderBy('date_debut', 'desc')->paginate(12);
        $zones = Zone::all();
        
        return view('project.front.index', compact('projects', 'zones'));
    }

    /**
     * Display the specified project.
     * Affiche les détails publics avec transparence budgétaire (sans infos sensibles).
     */
    public function show(Project $project)
    {
        // Vérifier que le projet n'est pas annulé
        if ($project->statut === 'annulé') {
            abort(404, 'Ce projet n\'est pas disponible.');
        }

        $project->load([
            'zone',
            'infrastructure',
            'responsable',
            'projectPhases.contractor',
            'fundings',
            'projectDocuments' => function ($query) {
                // Charger uniquement les documents publics
                $query->where('type', 'public')->orderBy('created_at', 'desc');
            }
        ]);
        
        return view('project.front.show', compact('project'));
    }
}
