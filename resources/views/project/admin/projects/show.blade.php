@extends('layouts.admin')

@section('title', 'Détails du Projet')

@section('content')
<x-project.layouts.admin
    title="Détails du Projet"
    :breadcrumbs="[
        ['label' => 'Tableau de bord', 'url' => route('dashboard')],
        ['label' => 'Projets', 'url' => route('admin.projects.index')],
        ['label' => 'Détails', 'url' => null]
    ]">

<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="d-flex align-items-center mb-2">
                <div class="rounded-2 bg-primary bg-opacity-10 p-2 me-3">
                    <i class="fas fa-folder-open fa-2x text-primary"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-1" style="color: #1a237e;">{{ $project->titre }}</h2>
                    <p class="text-muted mb-0">
                        <span class="badge bg-light text-primary border border-primary border-opacity-25 me-2">
                            {{ ucfirst($project->type) }}
                        </span>
                        @php
                            $statusBadge = match($project->statut) {
                                'planifié' => 'bg-secondary',
                                'en_cours' => 'bg-primary',
                                'terminé' => 'bg-success',
                                'suspendu' => 'bg-warning',
                                'annulé' => 'bg-danger',
                                default => 'bg-secondary'
                            };
                        @endphp
                        <span class="badge {{ $statusBadge }}">
                            {{ ucfirst(str_replace('_', ' ', $project->statut)) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-outline-primary">
                <i class="fas fa-edit me-2"></i>Modifier
            </a>
            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="fas fa-trash me-2"></i>Supprimer
            </button>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">
                Retour
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- Informations Générales --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-info-circle me-2 text-primary"></i>Informations Générales
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Description</label>
                            <p class="mb-0">{{ $project->description }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Responsable</label>
                            <p class="mb-0 fw-medium">
                                <i class="fas fa-user me-2 text-primary"></i>{{ $project->responsable->name ?? 'Non assigné' }}
                            </p>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small mb-1">Zone</label>
                            <p class="mb-0 fw-medium">
                                <i class="fas fa-map-marker-alt me-2 text-danger"></i>{{ $project->zone->nom ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small mb-1">Infrastructure</label>
                            <p class="mb-0 fw-medium">
                                <i class="fas fa-building me-2 text-secondary"></i>{{ $project->infrastructure->nom ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small mb-1">Dates</label>
                            <p class="mb-0">
                                {{ \Carbon\Carbon::parse($project->date_debut)->format('d/m/Y') }} → 
                                {{ \Carbon\Carbon::parse($project->date_fin_prevue)->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Phases --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-tasks me-2 text-primary"></i>Phases du Projet
                    </h5>
                    <span class="badge bg-light text-primary">{{ $project->projectPhases->count() }} phase(s)</span>
                </div>
                <div class="card-body p-0">
                    @if($project->projectPhases->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nom</th>
                                        <th>Date Début</th>
                                        <th>Date Fin</th>
                                        <th>Coût</th>
                                        <th>Avancement</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($project->projectPhases as $phase)
                                        <tr>
                                            <td class="fw-medium">{{ $phase->nom }}</td>
                                            <td>{{ \Carbon\Carbon::parse($phase->date_debut)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($phase->date_fin)->format('d/m/Y') }}</td>
                                            <td>{{ number_format($phase->cout, 0, ',', ' ') }} €</td>
                                            <td>
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar bg-primary" style="width: {{ $phase->avancement }}%"></div>
                                                </div>
                                                <small>{{ $phase->avancement }}%</small>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.phases.edit', $phase) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.phases.destroy', $phase) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer cette phase ?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="3" class="fw-bold">Total</td>
                                        <td class="fw-bold">{{ number_format($project->projectPhases->sum('cout'), 0, ',', ' ') }} €</td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-tasks fa-3x text-muted opacity-25 mb-3"></i>
                            <p class="text-muted">Aucune phase définie</p>
                            <a href="{{ route('admin.projects.phase.create', $project) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-2"></i>Ajouter une phase
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Financements --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-euro-sign me-2 text-primary"></i>Financements
                    </h5>
                    <span class="badge bg-light text-primary">{{ $project->fundings->count() }} source(s)</span>
                </div>
                <div class="card-body p-0">
                    @if($project->fundings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Source</th>
                                        <th>Type</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($project->fundings as $funding)
                                        <tr>
                                            <td class="fw-medium">{{ $funding->source }}</td>
                                            <td>{{ ucfirst($funding->type) }}</td>
                                            <td>{{ number_format($funding->montant, 0, ',', ' ') }} €</td>
                                            <td>
                                                @php
                                                    $fundingBadge = match($funding->statut) {
                                                        'en_attente' => 'bg-warning',
                                                        'approuvé' => 'bg-success',
                                                        'rejeté' => 'bg-danger',
                                                        default => 'bg-secondary'
                                                    };
                                                @endphp
                                                <span class="badge {{ $fundingBadge }}">{{ ucfirst(str_replace('_', ' ', $funding->statut)) }}</span>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group">
                                                    @if($funding->statut === 'en_attente')
                                                        <form action="{{ route('admin.fundings.approve', $funding) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-sm btn-outline-success">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.fundings.reject', $funding) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <a href="{{ route('admin.fundings.edit', $funding) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.fundings.destroy', $funding) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ce financement ?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="2" class="fw-bold">Total</td>
                                        <td class="fw-bold">{{ number_format($project->fundings->sum('montant'), 0, ',', ' ') }} €</td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-euro-sign fa-3x text-muted opacity-25 mb-3"></i>
                            <p class="text-muted">Aucun financement enregistré</p>
                            <a href="{{ route('admin.projects.funding.create', $project) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-2"></i>Ajouter un financement
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Documents --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-file-alt me-2 text-primary"></i>Documents
                    </h5>
                    <span class="badge bg-light text-primary">{{ $project->projectDocuments->count() }} document(s)</span>
                </div>
                <div class="card-body">
                    @if($project->projectDocuments->count() > 0)
                        <div class="row g-3">
                            @foreach($project->projectDocuments as $document)
                                <div class="col-md-4">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body text-center">
                                            <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
                                            <h6 class="fw-semibold mb-1">{{ $document->titre }}</h6>
                                            <small class="text-muted d-block mb-2">{{ Str::limit($document->description, 40) }}</small>
                                            <div class="btn-group w-100">
                                                <a href="{{ Storage::url($document->chemin_fichier) }}" class="btn btn-sm btn-outline-primary flex-grow-1" download>
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                <form action="{{ route('admin.documents.destroy', $document) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ce document ?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-alt fa-3x text-muted opacity-25 mb-3"></i>
                            <p class="text-muted">Aucun document attaché</p>
                            <a href="{{ route('admin.projects.document.create', $project) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-2"></i>Ajouter un document
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sidebar Info --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-chart-pie me-2 text-primary"></i>Budget
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Budget Prévu</label>
                        <h3 class="fw-bold text-primary">{{ number_format($project->budget_prevu, 0, ',', ' ') }} €</h3>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Financement Total</label>
                        <h3 class="fw-bold text-success">{{ number_format($project->fundingTotal(), 0, ',', ' ') }} €</h3>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Reste à Financer</label>
                        <h3 class="fw-bold text-warning">{{ number_format(max(0, $project->budget_prevu - $project->fundingTotal()), 0, ',', ' ') }} €</h3>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-success" style="width: {{ min(100, ($project->fundingTotal() / max(1, $project->budget_prevu)) * 100) }}%"></div>
                    </div>
                    <small class="text-muted">{{ number_format(min(100, ($project->fundingTotal() / max(1, $project->budget_prevu)) * 100), 1) }}% financé</small>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-tasks me-2 text-primary"></i>Avancement
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <h1 class="fw-bold display-4 text-primary">{{ $project->avancement_pourcentage }}%</h1>
                    </div>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar bg-primary" style="width: {{ $project->avancement_pourcentage }}%">{{ $project->avancement_pourcentage }}%</div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-bolt me-2 text-primary"></i>Actions Rapides
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.projects.phase.create', $project) }}" class="btn btn-outline-primary">
                            <i class="fas fa-plus me-2"></i>Ajouter une phase
                        </a>
                        <a href="{{ route('admin.projects.funding.create', $project) }}" class="btn btn-outline-success">
                            <i class="fas fa-euro-sign me-2"></i>Ajouter un financement
                        </a>
                        <a href="{{ route('admin.projects.document.create', $project) }}" class="btn btn-outline-info">
                            <i class="fas fa-file-upload me-2"></i>Ajouter un document
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-semibold">
                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                    Confirmer la suppression
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Êtes-vous sûr de vouloir supprimer le projet <strong>"{{ $project->titre }}"</strong> ?</p>
                <p class="text-muted small mb-0">Cette action est irréversible.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

</x-project.layouts.admin>
@endsection
