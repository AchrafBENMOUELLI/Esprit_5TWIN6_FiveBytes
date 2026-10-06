<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\Controller;
use App\Models\Project\Project;
use App\Models\Project\ProjectDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectDocumentController extends Controller
{
    /**
     * Afficher la liste des documents d'un projet.
     */
    public function index($projectId)
    {
        $project = Project::with('projectDocuments')->findOrFail($projectId);

        return view('project.admin.documents.index', compact('project'));
    }

    /**
     * Afficher le formulaire d'upload d'un document.
     */
    public function create($projectId)
    {
        $project = Project::findOrFail($projectId);

        return view('project.admin.documents.create', compact('project'));
    }

    /**
     * Uploader et enregistrer un nouveau document.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'nom' => 'required|string|max:200',
            'type_document' => 'required|in:cahier_charges,plan_technique,rapport_etude,photo,autre',
            'description' => 'nullable|string',
            'fichier' => 'required|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif'
        ], [
            'project_id.required' => 'Le projet est requis.',
            'project_id.exists' => 'Le projet sélectionné n\'existe pas.',
            'nom.required' => 'Le nom du document est requis.',
            'nom.max' => 'Le nom du document ne peut pas dépasser 200 caractères.',
            'type_document.required' => 'Le type de document est requis.',
            'type_document.in' => 'Le type de document sélectionné n\'est pas valide.',
            'fichier.required' => 'Le fichier est requis.',
            'fichier.file' => 'Le fichier uploadé n\'est pas valide.',
            'fichier.max' => 'Le fichier ne peut pas dépasser 10 Mo.',
            'fichier.mimes' => 'Le fichier doit être de type : pdf, doc, docx, xls, xlsx, jpg, jpeg, png, gif.'
        ]);

        $projectId = $request->project_id;
        $file = $request->file('fichier');

        // Générer un nom de fichier unique
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::slug($request->nom) . '_' . time() . '.' . $extension;

        // Stocker le fichier dans storage/app/public/projects/{projectId}/
        $path = $file->storeAs(
            'projects/' . $projectId,
            $fileName,
            'public'
        );

        // Créer l'enregistrement en base de données
        $document = ProjectDocument::create([
            'project_id' => $projectId,
            'nom' => $request->nom,
            'type_document' => $request->type_document,
            'chemin_fichier' => $path,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('admin.projects.show', $projectId)
            ->with('success', 'Le document "' . $document->nom . '" a été uploadé avec succès.');
    }

    /**
     * Afficher le formulaire d'édition d'un document.
     */
    public function edit($id)
    {
        $document = ProjectDocument::with('project')->findOrFail($id);

        return view('components.project.admin.documents.edit', compact('document'));
    }

    /**
     * Mettre à jour un document (métadonnées uniquement, pas le fichier).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:200',
            'type_document' => 'required|in:cahier_charges,plan_technique,rapport_etude,photo,autre',
            'description' => 'nullable|string',
        ], [
            'nom.required' => 'Le nom du document est requis.',
            'nom.max' => 'Le nom du document ne peut pas dépasser 200 caractères.',
            'type_document.required' => 'Le type de document est requis.',
            'type_document.in' => 'Le type de document sélectionné n\'est pas valide.',
        ]);

        $document = ProjectDocument::findOrFail($id);
        $document->update([
            'nom' => $request->nom,
            'type_document' => $request->type_document,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('admin.projects.show', $document->project_id)
            ->with('success', 'Le document "' . $document->nom . '" a été mis à jour avec succès.');
    }

    /**
     * Supprimer un document et son fichier du storage.
     */
    public function destroy($id)
    {
        $document = ProjectDocument::findOrFail($id);
        $projectId = $document->project_id;
        $nom = $document->nom;

        // Supprimer le fichier du storage
        if (Storage::disk('public')->exists($document->chemin_fichier)) {
            Storage::disk('public')->delete($document->chemin_fichier);
        }

        // Supprimer l'enregistrement en base de données
        $document->delete();

        return redirect()
            ->route('admin.projects.show', $projectId)
            ->with('success', 'Le document "' . $nom . '" a été supprimé avec succès.');
    }

    /**
     * Télécharger un document.
     */
    public function download($id)
    {
        $document = ProjectDocument::findOrFail($id);

        if (!Storage::disk('public')->exists($document->chemin_fichier)) {
            return redirect()
                ->back()
                ->with('error', 'Le fichier demandé n\'existe pas.');
        }

        return Storage::disk('public')->download(
            $document->chemin_fichier,
            $document->nom . '.' . pathinfo($document->chemin_fichier, PATHINFO_EXTENSION)
        );
    }
}
