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
     */
    public function index(Request $request)
    {
        $query = Project::with(['zone', 'infrastructure', 'responsable'])
            ->whereNotIn('statut', ['annulé']); // Ne pas afficher les projets annulés
        
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
        
        return view('components.project.front.index', compact('projects', 'zones'));
    }

    /**
     * Display the specified project.
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
        
        // Calculer les totaux
        $budgetTotal = $project->budgetTotal();
        $fundingTotal = $project->fundingTotal();
        $budgetRemaining = $project->budgetRemaining();
        
        return view('components.project.front.show', compact(
            'project',
            'budgetTotal',
            'fundingTotal',
            'budgetRemaining'
        ));
    }
}
