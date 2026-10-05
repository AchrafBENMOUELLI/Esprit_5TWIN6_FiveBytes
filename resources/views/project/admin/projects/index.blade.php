@extends('components.project.layouts.admin')

@section('title', 'Gestion des Projets')

@section('content')
<div class="container-fluid py-4">
    {{-- En-tête --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">Gestion des Projets de Rénovation</h1>
            <p class="text-muted">Gérer et suivre tous les projets de rénovation d'infrastructures</p>
        </div>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            Nouveau Projet
        </a>
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

    {{-- Filtres --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.projects.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Recherche</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="Titre du projet..." 
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-2">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-select" id="type" name="type">
                        <option value="">Tous les types</option>
                        <option value="réparation" {{ request('type') === 'réparation' ? 'selected' : '' }}>Réparation</option>
                        <option value="modernisation" {{ request('type') === 'modernisation' ? 'selected' : '' }}>Modernisation</option>
                        <option value="extension" {{ request('type') === 'extension' ? 'selected' : '' }}>Extension</option>
                        <option value="construction" {{ request('type') === 'construction' ? 'selected' : '' }}>Construction</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="statut" class="form-label">Statut</label>
                    <select class="form-select" id="statut" name="statut">
                        <option value="">Tous les statuts</option>
                        <option value="planifié" {{ request('statut') === 'planifié' ? 'selected' : '' }}>Planifié</option>
                        <option value="en_cours" {{ request('statut') === 'en_cours' ? 'selected' : '' }}>En cours</option>
                        <option value="terminé" {{ request('statut') === 'terminé' ? 'selected' : '' }}>Terminé</option>
                        <option value="suspendu" {{ request('statut') === 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                        <option value="annulé" {{ request('statut') === 'annulé' ? 'selected' : '' }}>Annulé</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="zone_id" class="form-label">Zone</label>
                    <select class="form-select" id="zone_id" name="zone_id">
                        <option value="">Toutes les zones</option>
                        @foreach(\App\Models\Infrastructure\Zone::all() as $zone)
                            <option value="{{ $zone->id }}" {{ request('zone_id') == $zone->id ? 'selected' : '' }}>
                                {{ $zone->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-search me-1"></i>
                        Filtrer
                    </button>
                    @if(request()->hasAny(['search', 'type', 'statut', 'zone_id']))
                        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-redo me-1"></i>
                            Réinitialiser
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Statistiques rapides --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                <i class="fas fa-project-diagram fa-2x text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Projets</h6>
                            <h3 class="mb-0">{{ $projects->total() }}</h3>
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
                            <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                <i class="fas fa-spinner fa-2x text-info"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">En cours</h6>
                            <h3 class="mb-0">{{ $projects->where('statut', 'en_cours')->count() }}</h3>
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
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Terminés</h6>
                            <h3 class="mb-0">{{ $projects->where('statut', 'terminé')->count() }}</h3>
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
                                <i class="fas fa-euro-sign fa-2x text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Budget Total</h6>
                            <h3 class="mb-0">{{ number_format($projects->sum('budget_prevu') / 1000000, 1) }}M €</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table des projets --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Projet</th>
                            <th>Type</th>
                            <th>Zone / Infrastructure</th>
                            <th>Budget</th>
                            <th>Dates</th>
                            <th>Statut</th>
                            <th>Avancement</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                            <tr>
                                <td>
                                    <strong class="d-block">{{ $project->titre }}</strong>
                                    <small class="text-muted">
                                        <i class="fas fa-user-tie me-1"></i>
                                        {{ $project->responsable->name ?? 'Non assigné' }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ ucfirst($project->type) }}</span>
                                </td>
                                <td>
                                    <div class="small">
                                        <div><i class="fas fa-map-marker-alt me-1 text-primary"></i>{{ $project->zone->nom ?? 'N/A' }}</div>
                                        <div class="text-muted"><i class="fas fa-building me-1"></i>{{ $project->infrastructure->nom ?? 'N/A' }}</div>
                                    </div>
                                </td>
                                <td>
                                    <strong>{{ number_format($project->budget_prevu, 0, ',', ' ') }} €</strong>
                                    @if($project->fundings->count() > 0)
                                        <div class="small text-success">
                                            <i class="fas fa-check me-1"></i>
                                            {{ number_format($project->fundingTotal(), 0, ',', ' ') }} € financé
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="small">
                                        <div>{{ \Carbon\Carbon::parse($project->date_debut)->format('d/m/Y') }}</div>
                                        <div class="text-muted">→ {{ \Carbon\Carbon::parse($project->date_fin_prevue)->format('d/m/Y') }}</div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match($project->statut) {
                                            'planifié' => 'secondary',
                                            'en_cours' => 'primary',
                                            'terminé' => 'success',
                                            'suspendu' => 'warning',
                                            'annulé' => 'danger',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $project->statut)) }}
                                    </span>
                                </td>
                                <td style="min-width: 120px;">
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-primary" role="progressbar" 
                                             style="width: {{ $project->avancement_pourcentage }}%"
                                             aria-valuenow="{{ $project->avancement_pourcentage }}" 
                                             aria-valuemin="0" aria-valuemax="100">
                                            {{ $project->avancement_pourcentage }}%
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.projects.show', $project) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.projects.edit', $project) }}" 
                                           class="btn btn-sm btn-outline-secondary" 
                                           title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.projects.destroy', $project) }}" 
                                              method="POST" 
                                              style="display: inline;"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-3">Aucun projet trouvé.</p>
                                    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>
                                        Créer le premier projet
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($projects->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $projects->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    .progress {
        border-radius: 10px;
    }
    .progress-bar {
        font-size: 0.75rem;
        font-weight: 600;
    }
</style>
@endpush
