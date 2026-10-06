@extends('layouts.admin')

@section('title', $contractor->nom)

@section('content')
<x-project.layouts.admin
    :title="$contractor->nom"
    :breadcrumbs="[
        ['label' => 'Tableau de bord', 'url' => route('dashboard')],
        ['label' => 'Contractants', 'url' => route('admin.contractors.index')],
        ['label' => $contractor->nom, 'url' => null]
    ]">

<div class="container-fluid py-4">
    {{-- En-tête --}}
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.contractors.index') }}">Contractants</a></li>
                <li class="breadcrumb-item active">{{ $contractor->nom }}</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h1 class="h2 mb-2">{{ $contractor->nom }}</h1>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-info fs-6">
                        <i class="fas fa-tools me-1"></i>
                        {{ ucfirst($contractor->specialite) }}
                    </span>
                    @if($contractor->projectPhases->count() > 0)
                        <span class="badge bg-success fs-6">
                            <i class="fas fa-check-circle me-1"></i>
                            Actif
                        </span>
                    @else
                        <span class="badge bg-secondary fs-6">
                            <i class="fas fa-pause-circle me-1"></i>
                            Inactif
                        </span>
                    @endif
                </div>
            </div>
            <div class="btn-group">
                <a href="{{ route('admin.contractors.edit', $contractor) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>
                    Modifier
                </a>
                <a href="{{ route('admin.contractors.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-list me-2"></i>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Colonne principale --}}
        <div class="col-md-8">
            {{-- Informations générales --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Informations du Contractant
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-building text-primary me-2"></i>
                                Nom de l'entreprise
                            </h6>
                            <p class="mb-0"><strong>{{ $contractor->nom }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-wrench text-primary me-2"></i>
                                Spécialité
                            </h6>
                            <p class="mb-0">{{ ucfirst($contractor->specialite) }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-phone text-primary me-2"></i>
                                Téléphone
                            </h6>
                            <p class="mb-0">
                                <a href="tel:{{ $contractor->telephone }}" class="text-decoration-none">
                                    {{ $contractor->telephone }}
                                </a>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                Email
                            </h6>
                            <p class="mb-0">
                                <a href="mailto:{{ $contractor->email }}" class="text-decoration-none">
                                    {{ $contractor->email }}
                                </a>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <h6 class="text-muted mb-2">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            Adresse
                        </h6>
                        <p class="mb-0">{{ $contractor->adresse }}</p>
                    </div>

                    <hr>

                    <div class="row text-muted">
                        <div class="col-md-6">
                            <small>
                                <i class="fas fa-calendar-plus me-1"></i>
                                Créé le: {{ $contractor->created_at->format('d/m/Y à H:i') }}
                            </small>
                        </div>
                        <div class="col-md-6">
                            <small>
                                <i class="fas fa-calendar-edit me-1"></i>
                                Modifié le: {{ $contractor->updated_at->format('d/m/Y à H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Liste des phases de projet --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tasks me-2"></i>
                        Phases de Projet Assignées
                    </h5>
                    <span class="badge bg-white text-primary">
                        {{ $contractor->projectPhases->count() }} phase(s)
                    </span>
                </div>
                <div class="card-body">
                    @if($contractor->projectPhases->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Projet</th>
                                        <th>Phase</th>
                                        <th>Période</th>
                                        <th>Coût</th>
                                        <th>Avancement</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contractor->projectPhases as $phase)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.projects.show', $phase->project) }}" 
                                                   class="text-decoration-none">
                                                    <strong>{{ $phase->project->titre }}</strong>
                                                </a>
                                                <div class="small text-muted">
                                                    <span class="badge bg-{{ $phase->project->statut === 'en_cours' ? 'success' : 'secondary' }} badge-sm">
                                                        {{ ucfirst(str_replace('_', ' ', $phase->project->statut)) }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <strong>{{ $phase->nom }}</strong>
                                            </td>
                                            <td>
                                                <div class="small">
                                                    <div>{{ \Carbon\Carbon::parse($phase->date_debut)->format('d/m/Y') }}</div>
                                                    <div class="text-muted">→ {{ \Carbon\Carbon::parse($phase->date_fin)->format('d/m/Y') }}</div>
                                                </div>
                                            </td>
                                            <td>
                                                <strong>{{ number_format($phase->cout, 0, ',', ' ') }} €</strong>
                                            </td>
                                            <td style="min-width: 120px;">
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-primary" 
                                                         role="progressbar" 
                                                         style="width: {{ $phase->avancement }}%"
                                                         aria-valuenow="{{ $phase->avancement }}" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="100">
                                                        {{ $phase->avancement }}%
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('admin.projects.show', $phase->project) }}" 
                                                   class="btn btn-sm btn-outline-primary"
                                                   title="Voir le projet">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total</strong></td>
                                        <td>
                                            <strong>{{ number_format($contractor->projectPhases->sum('cout'), 0, ',', ' ') }} €</strong>
                                        </td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-3">Aucune phase de projet assignée à ce contractant.</p>
                            <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-project-diagram me-2"></i>
                                Voir les projets
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Colonne latérale - Statistiques --}}
        <div class="col-md-4">
            {{-- Statistiques --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2"></i>
                        Statistiques
                    </h5>
                </div>
                <div class="card-body">
                    {{-- Nombre de phases --}}
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-muted mb-0">Phases Actives</h6>
                            <span class="badge bg-primary fs-5">{{ $contractor->projectPhases->count() }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" 
                                 style="width: {{ $contractor->projectPhases->count() > 0 ? 100 : 0 }}%">
                            </div>
                        </div>
                    </div>

                    {{-- Nombre de projets --}}
                    @php
                        $projectsCount = $contractor->projectPhases->pluck('project_id')->unique()->count();
                    @endphp
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-muted mb-0">Projets Distincts</h6>
                            <span class="badge bg-info fs-5">{{ $projectsCount }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-info" 
                                 style="width: {{ $projectsCount > 0 ? 100 : 0 }}%">
                            </div>
                        </div>
                    </div>

                    {{-- Montant total --}}
                    @php
                        $totalAmount = $contractor->projectPhases->sum('cout');
                    @endphp
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-muted mb-0">Montant Total</h6>
                            <span class="badge bg-success fs-5">{{ number_format($totalAmount / 1000, 1) }}K €</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" 
                                 style="width: {{ $totalAmount > 0 ? 100 : 0 }}%">
                            </div>
                        </div>
                    </div>

                    {{-- Avancement moyen --}}
                    @php
                        $avgProgress = $contractor->projectPhases->count() > 0 
                            ? $contractor->projectPhases->avg('avancement') 
                            : 0;
                    @endphp
                    <div class="mb-0">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-muted mb-0">Avancement Moyen</h6>
                            <span class="badge bg-warning fs-5">{{ number_format($avgProgress, 0) }}%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning" 
                                 style="width: {{ $avgProgress }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions rapides --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Actions Rapides
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="mailto:{{ $contractor->email }}" class="btn btn-outline-primary">
                            <i class="fas fa-envelope me-2"></i>
                            Envoyer un email
                        </a>
                        <a href="tel:{{ $contractor->telephone }}" class="btn btn-outline-success">
                            <i class="fas fa-phone me-2"></i>
                            Appeler
                        </a>
                        <a href="{{ route('admin.contractors.edit', $contractor) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-edit me-2"></i>
                            Modifier les infos
                        </a>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i>
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmer la suppression
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Êtes-vous sûr de vouloir supprimer ce contractant ?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>{{ $contractor->nom }}</strong>
                    @if($contractor->projectPhases->count() > 0)
                        <br><small class="text-danger">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Ce contractant est assigné à {{ $contractor->projectPhases->count() }} phase(s) de projet.
                        </small>
                    @endif
                </div>
                <p class="text-muted small mb-0">Cette action est irréversible.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>
                    Annuler
                </button>
                <form action="{{ route('admin.contractors.destroy', $contractor) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>
                        Supprimer définitivement
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .progress {
        border-radius: 10px;
    }
    .progress-bar {
        transition: width 0.6s ease;
    }
    .badge-sm {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
    }
</style>
@endpush

</x-project.layouts.admin>
@endsection
