<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreContractorRequest;
use App\Http\Requests\Project\UpdateContractorRequest;
use App\Models\Project\Contractor;
use Illuminate\Http\Request;

class ContractorController extends Controller
{
    /**
     * Afficher la liste des entrepreneurs avec recherche.
     */
    public function index(Request $request)
    {
        $query = Contractor::withCount('projectPhases');

        // Recherche par nom
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('specialite', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtre par spécialité
        if ($request->filled('specialite')) {
            $query->where('specialite', 'like', "%{$request->specialite}%");
        }

        $contractors = $query->orderBy('nom')->paginate(15);

        return view('project.admin.contractors.index', compact('contractors'));
    }

    /**
     * Afficher le formulaire de création d'un entrepreneur.
     */
    public function create()
    {
        return view('project.admin.contractors.create');
    }

    /**
     * Enregistrer un nouvel entrepreneur.
     */
    public function store(StoreContractorRequest $request)
    {
        $contractor = Contractor::create($request->validated());

        return redirect()
            ->route('admin.contractors.index')
            ->with('success', 'L\'entrepreneur "' . $contractor->nom . '" a été créé avec succès.');
    }

    /**
     * Afficher les détails d'un entrepreneur.
     */
    public function show(Contractor $contractor)
    {
        $contractor->load(['projectPhases.project']);
        
        return view('project.admin.contractors.show', compact('contractor'));
    }

    /**
     * Afficher le formulaire d'édition d'un entrepreneur.
     */
    public function edit(Contractor $contractor)
    {
        return view('project.admin.contractors.edit', compact('contractor'));
    }

    /**
     * Mettre à jour un entrepreneur.
     */
    public function update(UpdateContractorRequest $request, Contractor $contractor)
    {
        $contractor->update($request->validated());

        return redirect()
            ->route('admin.contractors.show', $contractor)
            ->with('success', 'L\'entrepreneur "' . $contractor->nom . '" a été mis à jour avec succès.');
    }

    /**
     * Supprimer un entrepreneur.
     * Vérifie qu'il n'a pas de phases associées.
     */
    public function destroy(Contractor $contractor)
    {
        $phasesCount = $contractor->projectPhases()->count();

        if ($phasesCount > 0) {
            return redirect()
                ->route('admin.contractors.show', $contractor)
                ->with('error', 'Impossible de supprimer cet entrepreneur car il est associé à ' . $phasesCount . ' phase(s) de projet. Veuillez d\'abord les réassigner ou les supprimer.');
        }

        $nom = $contractor->nom;
        $contractor->delete();

        return redirect()
            ->route('admin.contractors.index')
            ->with('success', 'L\'entrepreneur "' . $nom . '" a été supprimé avec succès.');
    }
}
