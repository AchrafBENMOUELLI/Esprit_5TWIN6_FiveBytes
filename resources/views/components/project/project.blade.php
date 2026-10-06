@php
    $projects = \App\Models\Project\Project::with(['zone', 'infrastructure', 'responsable'])
        ->when(request('search'), function($query, $search) {
            $query->where('titre', 'like', "%{$search}%");
        })
        ->when(request('type'), function($query, $type) {
            $query->where('type', $type);
        })
        ->when(request('statut'), function($query, $statut) {
            $query->where('statut', $statut);
        })
        ->when(request('zone_id'), function($query, $zoneId) {
            $query->where('zone_id', $zoneId);
        })
        ->paginate(10);
@endphp

<div class="container-fluid py-4">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1a237e;">Projets de Rénovation</h2>
            <p class="text-muted mb-0">Gérez et suivez tous vos projets de rénovation</p>
        </div>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-plus me-2"></i>Nouveau Projet
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-3 bg-primary bg-opacity-10 p-3 me-3">
                            <i class="fas fa-folder-open fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Projets</h6>
                            <h3 class="fw-bold mb-0">{{ $projects->total() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-3 bg-success bg-opacity-10 p-3 me-3">
                            <i class="fas fa-spinner fa-2x text-success"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">En Cours</h6>
                            <h3 class="fw-bold mb-0">{{ $projects->where('statut', 'en_cours')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-3 bg-info bg-opacity-10 p-3 me-3">
                            <i class="fas fa-check-circle fa-2x text-info"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Terminés</h6>
                            <h3 class="fw-bold mb-0">{{ $projects->where('statut', 'terminé')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-3 bg-warning bg-opacity-10 p-3 me-3">
                            <i class="fas fa-euro-sign fa-2x text-warning"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Budget Total</h6>
                            <h3 class="fw-bold mb-0">{{ number_format($projects->sum('budget_prevu') / 1000000, 1) }}M €</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters Card --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-semibold">
                <i class="fas fa-filter me-2 text-primary"></i>Filtres
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('dashboard', ['module' => 'project']) }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-medium">Recherche</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 bg-light" name="search" 
                               placeholder="Titre du projet..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-medium">Type</label>
                    <select class="form-select" name="type">
                        <option value="">Tous</option>
                        <option value="réparation" {{ request('type') === 'réparation' ? 'selected' : '' }}>Réparation</option>
                        <option value="modernisation" {{ request('type') === 'modernisation' ? 'selected' : '' }}>Modernisation</option>
                        <option value="extension" {{ request('type') === 'extension' ? 'selected' : '' }}>Extension</option>
                        <option value="construction" {{ request('type') === 'construction' ? 'selected' : '' }}>Construction</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-medium">Statut</label>
                    <select class="form-select" name="statut">
                        <option value="">Tous</option>
                        <option value="planifié" {{ request('statut') === 'planifié' ? 'selected' : '' }}>Planifié</option>
                        <option value="en_cours" {{ request('statut') === 'en_cours' ? 'selected' : '' }}>En cours</option>
                        <option value="terminé" {{ request('statut') === 'terminé' ? 'selected' : '' }}>Terminé</option>
                        <option value="suspendu" {{ request('statut') === 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                        <option value="annulé" {{ request('statut') === 'annulé' ? 'selected' : '' }}>Annulé</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-medium">Zone</label>
                    <select class="form-select" name="zone_id">
                        <option value="">Toutes</option>
                        @foreach(\App\Models\Infrastructure\Zone::all() as $zone)
                            <option value="{{ $zone->id }}" {{ request('zone_id') == $zone->id ? 'selected' : '' }}>
                                {{ $zone->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="fas fa-search me-2"></i>Filtrer
                    </button>
                    @if(request()->hasAny(['search', 'type', 'statut', 'zone_id']))
                        <a href="{{ route('dashboard', ['module' => 'project']) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-redo"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Projects Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-semibold">
                <i class="fas fa-list me-2 text-primary"></i>Liste des Projets
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Projet</th>
                            <th>Type</th>
                            <th>Zone / Infrastructure</th>
                            <th>Budget</th>
                            <th>Dates</th>
                            <th>Statut</th>
                            <th>Avancement</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-2 bg-primary bg-opacity-10 p-2 me-3">
                                            <i class="fas fa-project-diagram text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-0">{{ $project->titre }}</h6>
                                            <small class="text-muted">
                                                <i class="fas fa-user me-1"></i>{{ $project->responsable->name ?? 'Non assigné' }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-primary border border-primary border-opacity-25">
                                        {{ ucfirst($project->type) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="small">
                                        <div class="fw-medium">
                                            <i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $project->zone->nom ?? 'N/A' }}
                                        </div>
                                        <div class="text-muted">
                                            <i class="fas fa-building text-secondary me-1"></i>{{ $project->infrastructure->nom ?? 'N/A' }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ number_format($project->budget_prevu, 0, ',', ' ') }} €</div>
                                    @if($project->fundings->count() > 0)
                                        <small class="text-success">
                                            <i class="fas fa-check-circle me-1"></i>{{ number_format($project->fundingTotal(), 0, ',', ' ') }} €
                                        </small>
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
                                </td>
                                <td style="min-width: 140px;">
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-primary" role="progressbar" 
                                             style="width: {{ $project->avancement_pourcentage }}%"
                                             aria-valuenow="{{ $project->avancement_pourcentage }}" 
                                             aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ $project->avancement_pourcentage }}%</small>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.projects.show', $project) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           data-bs-toggle="tooltip" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.projects.edit', $project) }}" 
                                           class="btn btn-sm btn-outline-secondary" 
                                           data-bs-toggle="tooltip" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal{{ $project->id }}"
                                                data-bs-toggle="tooltip" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-folder-open fa-4x mb-3 opacity-25"></i>
                                        <p class="mb-3">Aucun projet trouvé.</p>
                                        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Créer le premier projet
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($projects->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $projects->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

{{-- Delete Modals --}}
@foreach($projects as $project)
    <div class="modal fade" id="deleteModal{{ $project->id }}" tabindex="-1">
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
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
