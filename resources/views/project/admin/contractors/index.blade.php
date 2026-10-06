@extends('layouts.admin')

@section('title', 'Gestion des Contractants')

@section('content')
<x-project.layouts.admin
    title="Gestion des Contractants"
    :breadcrumbs="[
        ['label' => 'Tableau de bord', 'url' => route('dashboard')],
        ['label' => 'Contractants', 'url' => null]
    ]">

<div class="container-fluid py-4">
    {{-- En-tête --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">Gestion des Contractants</h1>
            <p class="text-muted">Gérer les entreprises et prestataires pour les phases de projet</p>
        </div>
        <a href="{{ route('admin.contractors.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            Nouveau Contractant
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
            <form method="GET" action="{{ route('admin.contractors.index') }}" class="row g-3">
                <div class="col-md-5">
                    <label for="search" class="form-label">Recherche</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="Nom du contractant..." 
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-4">
                    <label for="specialite" class="form-label">Spécialité</label>
                    <input type="text" class="form-control" id="specialite" name="specialite" 
                           placeholder="Ex: plomberie, électricité..." 
                           value="{{ request('specialite') }}">
                </div>

                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-search me-1"></i>
                        Filtrer
                    </button>
                    @if(request()->hasAny(['search', 'specialite']))
                        <a href="{{ route('admin.contractors.index') }}" class="btn btn-outline-secondary">
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
                                <i class="fas fa-building fa-2x text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Contractants</h6>
                            <h3 class="mb-0">{{ $contractors->total() }}</h3>
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
                                <i class="fas fa-user-check fa-2x text-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Actifs</h6>
                            <h3 class="mb-0">{{ $contractors->filter(fn($c) => $c->projectPhases->count() > 0)->count() }}</h3>
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
                                <i class="fas fa-tasks fa-2x text-info"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Phases Totales</h6>
                            <h3 class="mb-0">{{ $contractors->sum(fn($c) => $c->projectPhases->count()) }}</h3>
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
                                <i class="fas fa-wrench fa-2x text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Spécialités</h6>
                            <h3 class="mb-0">{{ $contractors->pluck('specialite')->unique()->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table des contractants --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Contractant</th>
                            <th>Spécialité</th>
                            <th>Contact</th>
                            <th>Adresse</th>
                            <th class="text-center">Phases Actives</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contractors as $contractor)
                            <tr>
                                <td>
                                    <strong class="d-block">{{ $contractor->nom }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        <i class="fas fa-tools me-1"></i>
                                        {{ ucfirst($contractor->specialite) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="small">
                                        @if($contractor->telephone)
                                            <div class="mb-1">
                                                <i class="fas fa-phone text-primary me-1"></i>
                                                <a href="tel:{{ $contractor->telephone }}">{{ $contractor->telephone }}</a>
                                            </div>
                                        @endif
                                        @if($contractor->email)
                                            <div>
                                                <i class="fas fa-envelope text-primary me-1"></i>
                                                <a href="mailto:{{ $contractor->email }}">{{ $contractor->email }}</a>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="small text-muted" style="max-width: 200px;">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ Str::limit($contractor->adresse ?? 'Non renseignée', 50) }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    @php
                                        $phasesCount = $contractor->projectPhases->count();
                                    @endphp
                                    @if($phasesCount > 0)
                                        <span class="badge bg-success fs-6">{{ $phasesCount }}</span>
                                        <div class="small text-muted">phase(s)</div>
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-minus"></i>
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.contractors.show', $contractor) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.contractors.edit', $contractor) }}" 
                                           class="btn btn-sm btn-outline-secondary" 
                                           title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                title="Supprimer"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal{{ $contractor->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-building fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-3">Aucun contractant trouvé.</p>
                                    <a href="{{ route('admin.contractors.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>
                                        Ajouter le premier contractant
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($contractors->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $contractors->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Delete Modals --}}
@foreach($contractors as $contractor)
<div class="modal fade" id="deleteModal{{ $contractor->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $contractor->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel{{ $contractor->id }}">
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
@endforeach

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    .table td a {
        color: inherit;
        text-decoration: none;
    }
    .table td a:hover {
        text-decoration: underline;
    }
</style>
@endpush

</x-project.layouts.admin>
@endsection
