<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectPhaseRequest;
use App\Models\Project\Project;
use App\Models\Project\ProjectPhase;
use App\Models\Project\Contractor;
use Illuminate\Http\Request;

class ProjectPhaseController extends Controller
{
    /**
     * Afficher la liste des phases d'un projet.
     */
    public function index($projectId)
    {
        $project = Project::with(['projectPhases.contractor'])->findOrFail($projectId);

        return view('components.project.admin.phases.index', compact('project'));
    }

    /**
     * Afficher le formulaire de création d'une phase.
     */
    public function create($projectId)
    {
        $project = Project::findOrFail($projectId);
        $contractors = Contractor::orderBy('nom')->get();

        return view('project.admin.phases.create', compact('project', 'contractors'));
    }

    /**
     * Enregistrer une nouvelle phase.
     */
    public function store(StoreProjectPhaseRequest $request)
    {
        $phase = ProjectPhase::create($request->validated());

        return redirect()
            ->route('admin.projects.show', $phase->project_id)
            ->with('success', 'La phase "' . $phase->nom . '" a été créée avec succès.');
    }

    /**
     * Afficher le formulaire d'édition d'une phase.
     */
    public function edit($id)
    {
        $phase = ProjectPhase::with('project')->findOrFail($id);
        $contractors = Contractor::orderBy('nom')->get();

        return view('project.admin.phases.edit', compact('phase', 'contractors'));
    }

    /**
     * Mettre à jour une phase.
     */
    public function update(StoreProjectPhaseRequest $request, $id)
    {
        $phase = ProjectPhase::findOrFail($id);
        $phase->update($request->validated());

        return redirect()
            ->route('admin.projects.show', $phase->project_id)
            ->with('success', 'La phase "' . $phase->nom . '" a été mise à jour avec succès.');
    }

    /**
     * Supprimer une phase.
     */
    public function destroy($id)
    {
        $phase = ProjectPhase::findOrFail($id);
        $projectId = $phase->project_id;
        $nom = $phase->nom;
        
        $phase->delete();

        return redirect()
            ->route('admin.projects.show', $projectId)
            ->with('success', 'La phase "' . $nom . '" a été supprimée avec succès.');
    }
}
