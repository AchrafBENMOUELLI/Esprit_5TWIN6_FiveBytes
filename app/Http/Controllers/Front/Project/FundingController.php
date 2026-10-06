<?php

namespace App\Http\Controllers\Front\Project;

use App\Http\Controllers\Controller;
use App\Models\Project\Project;
use App\Models\Project\Funding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FundingController extends Controller
{
    /**
     * Afficher le formulaire de simulation de don pour un projet.
     */
    public function simulateDonation($projectId)
    {
        $project = Project::with(['zone', 'infrastructure', 'responsable'])
            ->where('statut', '!=', 'annulé')
            ->findOrFail($projectId);

        // Calculer les informations budgétaires pour afficher à l'utilisateur
        $budgetPrevu = $project->budget_prevu;
        $fundingTotal = $project->fundingTotal();
        $budgetRemaining = $budgetPrevu - $fundingTotal;

        return view('project.front.donate', compact('project', 'budgetPrevu', 'fundingTotal', 'budgetRemaining'));
    }

    /**
     * Enregistrer un don simulé pour un projet.
     * L'utilisateur connecté devient le donateur.
     */
    public function storeDonation(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'montant' => 'required|numeric|min:1|max:1000000',
            'description' => 'nullable|string|max:1000',
        ], [
            'project_id.required' => 'Le projet est requis.',
            'project_id.exists' => 'Le projet sélectionné n\'existe pas.',
            'montant.required' => 'Le montant du don est requis.',
            'montant.numeric' => 'Le montant doit être un nombre.',
            'montant.min' => 'Le montant minimum est de 1 €.',
            'montant.max' => 'Le montant maximum est de 1 000 000 €.',
            'description.max' => 'La description ne peut pas dépasser 1000 caractères.',
        ]);

        // Vérifier que le projet n'est pas annulé
        $project = Project::where('id', $validated['project_id'])
            ->where('statut', '!=', 'annulé')
            ->firstOrFail();

        // Créer le financement avec l'utilisateur connecté comme donateur
        $funding = Funding::create([
            'project_id' => $validated['project_id'],
            'source' => 'don',
            'montant' => $validated['montant'],
            'date_obtention' => now(),
            'statut' => 'en_attente', // En attente d'approbation par un gestionnaire
            'donateur_id' => Auth::id(),
            'description' => $validated['description'] ?? 'Don de ' . Auth::user()->name,
        ]);

        return redirect()
            ->route('project.show', $validated['project_id'])
            ->with('success', 'Merci pour votre don de ' . number_format($funding->montant, 2, ',', ' ') . ' € ! Votre contribution sera examinée par notre équipe et vous recevrez une confirmation prochainement.');
    }

    /**
     * Afficher l'historique des dons de l'utilisateur connecté.
     */
    public function myDonations()
    {
        $donations = Funding::with(['project.zone'])
            ->where('donateur_id', Auth::id())
            ->where('source', 'don')
            ->orderBy('date_obtention', 'desc')
            ->paginate(10);

        return view('components.project.front.my-donations', compact('donations'));
    }
}
