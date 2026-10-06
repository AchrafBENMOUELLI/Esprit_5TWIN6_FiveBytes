<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreFundingRequest;
use App\Models\Project\Project;
use App\Models\Project\Funding;
use App\Models\User;
use Illuminate\Http\Request;

class FundingController extends Controller
{
    /**
     * Afficher la liste des financements d'un projet.
     */
    public function index($projectId)
    {
        $project = Project::with(['fundings.donateur'])->findOrFail($projectId);

        return view('components.project.admin.fundings.index', compact('project'));
    }

    /**
     * Afficher le formulaire de création d'un financement.
     */
    public function create($projectId)
    {
        $project = Project::findOrFail($projectId);
        $donateurs = User::whereHas('donations')->orWhere('id', '>', 0)->orderBy('name')->get();

        return view('project.admin.fundings.create', compact('project', 'donateurs'));
    }

    /**
     * Enregistrer un nouveau financement.
     */
    public function store(StoreFundingRequest $request)
    {
        $funding = Funding::create($request->validated());

        return redirect()
            ->route('admin.projects.show', $funding->project_id)
            ->with('success', 'Le financement de ' . number_format($funding->montant, 2, ',', ' ') . ' € a été créé avec succès.');
    }

    /**
     * Afficher le formulaire d'édition d'un financement.
     */
    public function edit($id)
    {
        $funding = Funding::with('project')->findOrFail($id);
        $donateurs = User::whereHas('donations')->orWhere('id', '>', 0)->orderBy('name')->get();

        return view('components.project.admin.fundings.edit', compact('funding', 'donateurs'));
    }

    /**
     * Mettre à jour un financement.
     */
    public function update(StoreFundingRequest $request, $id)
    {
        $funding = Funding::findOrFail($id);
        $funding->update($request->validated());

        return redirect()
            ->route('admin.projects.show', $funding->project_id)
            ->with('success', 'Le financement a été mis à jour avec succès.');
    }

    /**
     * Supprimer un financement.
     */
    public function destroy($id)
    {
        $funding = Funding::findOrFail($id);
        $projectId = $funding->project_id;
        $montant = number_format($funding->montant, 2, ',', ' ');
        
        $funding->delete();

        return redirect()
            ->route('admin.projects.show', $projectId)
            ->with('success', 'Le financement de ' . $montant . ' € a été supprimé avec succès.');
    }
}
