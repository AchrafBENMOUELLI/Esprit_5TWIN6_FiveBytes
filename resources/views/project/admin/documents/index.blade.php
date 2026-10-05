@extends('components.project.layouts.admin')

@section('title', 'Documents du Projet')

@section('content')
<div class="container-fluid py-4">
    {{-- En-tête avec contexte du projet --}}
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Projets</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.projects.show', $project) }}">{{ $project->titre }}</a></li>
                <li class="breadcrumb-item active">Documents</li>
            </ol>
        </nav>
        
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h2 mb-2">Documents du Projet</h1>
                <p class="text-muted">{{ $project->titre }}</p>
            </div>
            <div>
                <a href="{{ route('admin.project-documents.create', ['project_id' => $project->id]) }}" 
                   class="btn btn-info">
                    <i class="fas fa-upload me-2"></i>
                    Ajouter un document
                </a>
                <a href="{{ route('admin.projects.show', $project) }}" 
                   class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Retour
                </a>
            </div>
        </div>
    </div>

    {{-- Messages Flash --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Statistiques --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                <i class="fas fa-file-alt fa-2x text-info"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Documents</h6>
                            <h3 class="mb-0">{{ $documents->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                <i class="fas fa-drafting-compass fa-2x text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Plans</h6>
                            <h3 class="mb-0">{{ $documents->where('type_document', 'plan')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                <i class="fas fa-camera fa-2x text-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Photos</h6>
                            <h3 class="mb-0">{{ $documents->where('type_document', 'photo')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                <i class="fas fa-file-invoice fa-2x text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Factures</h6>
                            <h3 class="mb-0">{{ $documents->where('type_document', 'facture')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtres par type --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="text-muted">Filtrer par type:</span>
                <a href="{{ route('admin.project-documents.index', ['project_id' => $project->id]) }}" 
                   class="btn btn-sm {{ !request('type') ? 'btn-info' : 'btn-outline-info' }}">
                    Tous
                </a>
                <a href="{{ route('admin.project-documents.index', ['project_id' => $project->id, 'type' => 'plan']) }}" 
                   class="btn btn-sm {{ request('type') === 'plan' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fas fa-drafting-compass me-1"></i> Plans
                </a>
                <a href="{{ route('admin.project-documents.index', ['project_id' => $project->id, 'type' => 'rapport']) }}" 
                   class="btn btn-sm {{ request('type') === 'rapport' ? 'btn-secondary' : 'btn-outline-secondary' }}">
                    <i class="fas fa-file-alt me-1"></i> Rapports
                </a>
                <a href="{{ route('admin.project-documents.index', ['project_id' => $project->id, 'type' => 'photo']) }}" 
                   class="btn btn-sm {{ request('type') === 'photo' ? 'btn-success' : 'btn-outline-success' }}">
                    <i class="fas fa-camera me-1"></i> Photos
                </a>
                <a href="{{ route('admin.project-documents.index', ['project_id' => $project->id, 'type' => 'facture']) }}" 
                   class="btn btn-sm {{ request('type') === 'facture' ? 'btn-warning' : 'btn-outline-warning' }}">
                    <i class="fas fa-file-invoice me-1"></i> Factures
                </a>
            </div>
        </div>
    </div>

    {{-- Grille de documents --}}
    @if($documents->count() > 0)
        <div class="row g-4">
            @foreach($documents as $document)
                <div class="col-md-4 col-lg-3">
                    <div class="card border-0 shadow-sm h-100 document-card">
                        <div class="card-body">
                            {{-- Icône selon le type --}}
                            <div class="text-center mb-3">
                                @php
                                    $extension = pathinfo($document->chemin_fichier, PATHINFO_EXTENSION);
                                    $iconClass = 'fa-file';
                                    $iconColor = 'text-secondary';
                                    
                                    if ($document->type_document === 'plan') {
                                        $iconClass = 'fa-drafting-compass';
                                        $iconColor = 'text-primary';
                                    } elseif ($document->type_document === 'photo') {
                                        $iconClass = 'fa-image';
                                        $iconColor = 'text-success';
                                    } elseif ($document->type_document === 'facture') {
                                        $iconClass = 'fa-file-invoice';
                                        $iconColor = 'text-warning';
                                    } elseif (in_array($extension, ['pdf'])) {
                                        $iconClass = 'fa-file-pdf';
                                        $iconColor = 'text-danger';
                                    } elseif (in_array($extension, ['doc', 'docx'])) {
                                        $iconClass = 'fa-file-word';
                                        $iconColor = 'text-primary';
                                    } elseif (in_array($extension, ['xls', 'xlsx'])) {
                                        $iconClass = 'fa-file-excel';
                                        $iconColor = 'text-success';
                                    }
                                @endphp
                                <i class="fas {{ $iconClass }} {{ $iconColor }}" style="font-size: 4rem;"></i>
                            </div>

                            {{-- Nom du document --}}
                            <h6 class="card-title text-center mb-2">{{ $document->nom }}</h6>
                            
                            {{-- Type badge --}}
                            <div class="text-center mb-2">
                                <span class="badge bg-{{ 
                                    match($document->type_document) {
                                        'plan' => 'primary',
                                        'rapport' => 'secondary',
                                        'photo' => 'success',
                                        'facture' => 'warning',
                                        'contrat' => 'info',
                                        default => 'secondary'
                                    }
                                }}">
                                    {{ ucfirst($document->type_document) }}
                                </span>
                            </div>

                            {{-- Description --}}
                            @if($document->description)
                                <p class="small text-muted text-center mb-3">
                                    {{ Str::limit($document->description, 60) }}
                                </p>
                            @endif

                            {{-- Infos fichier --}}
                            <div class="small text-muted text-center mb-3">
                                @if(Storage::exists($document->chemin_fichier))
                                    <div><i class="fas fa-hdd me-1"></i> {{ $this->formatFileSize(Storage::size($document->chemin_fichier)) }}</div>
                                @endif
                                <div><i class="fas fa-calendar me-1"></i> {{ $document->created_at->format('d/m/Y') }}</div>
                                <div><i class="fas fa-file-alt me-1"></i> .{{ $extension }}</div>
                            </div>

                            {{-- Actions --}}
                            <div class="d-grid gap-2">
                                <a href="{{ Storage::url($document->chemin_fichier) }}" 
                                   class="btn btn-sm btn-info" 
                                   download
                                   title="Télécharger">
                                    <i class="fas fa-download me-1"></i>
                                    Télécharger
                                </a>
                                <form action="{{ route('admin.project-documents.destroy', $document) }}" 
                                      method="POST"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                        <i class="fas fa-trash me-1"></i>
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                <h4 class="mb-3">Aucun document trouvé</h4>
                <p class="text-muted mb-4">
                    {{ request('type') ? 'Aucun document de ce type.' : 'Ce projet n\'a pas encore de documents.' }}
                </p>
                <a href="{{ route('admin.project-documents.create', ['project_id' => $project->id]) }}" 
                   class="btn btn-info">
                    <i class="fas fa-upload me-2"></i>
                    Ajouter le premier document
                </a>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .document-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .document-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // Helper function pour formater la taille des fichiers
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 B';
        const k = 1024;
        const sizes = ['B', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }
</script>
@endpush
