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

<style>
    /* Page spacing is handled by the admin layout, like the Entrepreneurs page. */
    .aq-project-main {
        width: 100%;
    }

    /* Minimalistic Stats Cards */
    .minimal-stat-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        border: none;
        box-shadow: 0 1px 3px rgba(30, 64, 175, 0.08);
        transition: all 0.3s ease;
    }

    .minimal-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(30, 64, 175, 0.12);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 20px;
        margin-bottom: 16px;
    }

    .stat-icon.blue {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(96, 165, 250, 0.15));
        color: #3b82f6;
    }

    .stat-icon.green {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(52, 211, 153, 0.15));
        color: #10b981;
    }

    .stat-icon.cyan {
        background: linear-gradient(135deg, rgba(6, 182, 212, 0.1), rgba(34, 211, 238, 0.15));
        color: #06b6d4;
    }

    .stat-icon.amber {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(251, 191, 36, 0.15));
        color: #f59e0b;
    }

    .stat-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
        margin-bottom: 4px;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #1e293b;
        line-height: 1;
    }

    /* Minimalistic Table */
    .minimal-table {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(30, 64, 175, 0.08);
    }

    .minimal-table thead {
        background: linear-gradient(to right, #f8fafc, #f1f5f9);
        border-bottom: 1px solid #e2e8f0;
    }

    .minimal-table thead th {
        padding: 16px 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        border: none;
    }

    .minimal-table tbody td {
        padding: 20px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        font-size: 14px;
    }

    .minimal-table tbody tr:last-child td {
        border-bottom: none;
    }

    .minimal-table tbody tr {
        transition: background 0.2s ease;
    }

    .minimal-table tbody tr:hover {
        background: linear-gradient(to right, rgba(59, 130, 246, 0.02), transparent);
    }

    /* Minimalistic Badges */
    .minimal-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.025em;
    }

    .minimal-badge.type {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
        color: #6366f1;
    }

    .minimal-badge.status-planned {
        background: rgba(100, 116, 139, 0.1);
        color: #64748b;
    }

    .minimal-badge.status-in-progress {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(96, 165, 250, 0.15));
        color: #3b82f6;
    }

    .minimal-badge.status-completed {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(52, 211, 153, 0.15));
        color: #10b981;
    }

    .minimal-badge.status-suspended {
        background: rgba(245, 158, 11, 0.15);
        color: #f59e0b;
    }

    .minimal-badge.status-cancelled {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
    }

    /* Minimalistic Buttons */
    .minimal-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .minimal-btn-primary {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    }

    .minimal-btn-primary:hover {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .minimal-btn-ghost {
        background: transparent;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
    }

    .minimal-btn-ghost:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #475569;
    }

    .minimal-btn-icon {
        width: 36px;
        height: 36px;
        padding: 0;
        background: transparent;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
    }

    .minimal-btn-icon:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #3b82f6;
    }

    /* Progress bar */
    .minimal-progress {
        height: 6px;
        background: #e2e8f0;
        border-radius: 3px;
        overflow: hidden;
    }

    .minimal-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #3b82f6, #60a5fa);
        border-radius: 3px;
        transition: width 0.6s ease;
    }

    /* Filters */
    .minimal-filter-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(30, 64, 175, 0.08);
    }

    .minimal-input {
        padding: 10px 16px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .minimal-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .minimal-select {
        padding: 10px 16px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.2s ease;
        background: white;
    }

    .minimal-select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
</style>

<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="fw-bold mb-2" style="font-size: 32px; background: linear-gradient(135deg, #1e40af, #3b82f6, #60a5fa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                Projets de Rénovation
            </h1>
            <p class="text-muted mb-0" style="font-size: 15px;">Gérez et suivez tous vos projets d'infrastructure</p>
        </div>
        <a href="{{ route('admin.projects.create') }}" class="minimal-btn minimal-btn-primary" style="padding: 12px 24px; font-size: 14px;">
            <i class="fas fa-plus" style="margin-right: 8px; font-size: 12px;"></i>Nouveau Projet
        </a>
    </div>

    {{-- Stats --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="minimal-stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-folder-open"></i>
                </div>
                <div class="stat-label">Total Projets</div>
                <div class="stat-value">{{ $projects->total() }}</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="minimal-stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-spinner"></i>
                </div>
                <div class="stat-label">En Cours</div>
                <div class="stat-value">{{ $projects->where('statut', 'en_cours')->count() }}</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="minimal-stat-card">
                <div class="stat-icon cyan">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-label">Terminés</div>
                <div class="stat-value">{{ $projects->where('statut', 'terminé')->count() }}</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="minimal-stat-card">
                <div class="stat-icon amber">
                    <i class="fas fa-euro-sign"></i>
                </div>
                <div class="stat-label">Budget Total</div>
                <div class="stat-value">{{ number_format($projects->sum('budget_prevu') / 1000000, 1) }}M €</div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="minimal-filter-card mb-4">
        <form method="GET" action="{{ route('dashboard', ['module' => 'project']) }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label" style="font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 8px;">Recherche</label>
                <input type="text" class="minimal-input w-100" name="search" placeholder="Titre du projet..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label" style="font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 8px;">Type</label>
                <select class="minimal-select w-100" name="type">
                    <option value="">Tous</option>
                    <option value="réparation" {{ request('type') === 'réparation' ? 'selected' : '' }}>Réparation</option>
                    <option value="modernisation" {{ request('type') === 'modernisation' ? 'selected' : '' }}>Modernisation</option>
                    <option value="extension" {{ request('type') === 'extension' ? 'selected' : '' }}>Extension</option>
                    <option value="construction" {{ request('type') === 'construction' ? 'selected' : '' }}>Construction</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label" style="font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 8px;">Statut</label>
                <select class="minimal-select w-100" name="statut">
                    <option value="">Tous</option>
                    <option value="planifié" {{ request('statut') === 'planifié' ? 'selected' : '' }}>Planifié</option>
                    <option value="en_cours" {{ request('statut') === 'en_cours' ? 'selected' : '' }}>En cours</option>
                    <option value="terminé" {{ request('statut') === 'terminé' ? 'selected' : '' }}>Terminé</option>
                    <option value="suspendu" {{ request('statut') === 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                    <option value="annulé" {{ request('statut') === 'annulé' ? 'selected' : '' }}>Annulé</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label" style="font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 8px;">Zone</label>
                <select class="minimal-select w-100" name="zone_id">
                    <option value="">Toutes</option>
                    @foreach(\App\Models\Infrastructure\Zone::all() as $zone)
                        <option value="{{ $zone->id }}" {{ request('zone_id') == $zone->id ? 'selected' : '' }}>{{ $zone->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <div class="d-flex gap-2">
                    <button type="submit" class="minimal-btn minimal-btn-primary flex-grow-1">
                        <i class="fas fa-search" style="margin-right: 8px; font-size: 12px;"></i>Filtrer
                    </button>
                    @if(request()->hasAny(['search', 'type', 'statut', 'zone_id']))
                        <a href="{{ route('dashboard', ['module' => 'project']) }}" class="minimal-btn minimal-btn-icon">
                            <i class="fas fa-redo" style="font-size: 12px;"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="minimal-table">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width: 25%;">Projet</th>
                    <th style="width: 10%;">Type</th>
                    <th style="width: 15%;">Zone</th>
                    <th style="width: 12%;">Budget</th>
                    <th style="width: 12%;">Dates</th>
                    <th style="width: 10%;">Statut</th>
                    <th style="width: 10%;">Avancement</th>
                    <th style="width: 6%;" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                    <tr>
                        <td>
                            <div style="font-weight: 600; color: #1e293b; margin-bottom: 4px;">{{ $project->titre }}</div>
                            <div style="font-size: 12px; color: #94a3b8;">
                                <i class="fas fa-user" style="font-size: 10px; margin-right: 4px;"></i>{{ $project->responsable->name ?? 'Non assigné' }}
                            </div>
                        </td>
                        <td>
                            <span class="minimal-badge type">{{ ucfirst($project->type) }}</span>
                        </td>
                        <td>
                            <div style="font-size: 13px; color: #64748b; line-height: 1.6;">
                                <div><i class="fas fa-map-marker-alt" style="font-size: 10px; margin-right: 6px; color: #ef4444;"></i>{{ $project->zone->nom ?? 'N/A' }}</div>
                                <div><i class="fas fa-building" style="font-size: 10px; margin-right: 6px; color: #94a3b8;"></i>{{ Str::limit($project->infrastructure->nom ?? 'N/A', 20) }}</div>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #1e293b;">{{ number_format($project->budget_prevu / 1000, 0) }}K €</div>
                            @if($project->fundings->count() > 0)
                                <div style="font-size: 11px; color: #10b981; margin-top: 2px;">
                                    <i class="fas fa-check-circle" style="font-size: 9px; margin-right: 3px;"></i>{{ number_format($project->fundingTotal() / 1000, 0) }}K €
                                </div>
                            @endif
                        </td>
                        <td style="font-size: 12px; color: #64748b; line-height: 1.6;">
                            <div>{{ \Carbon\Carbon::parse($project->date_debut)->format('d/m/Y') }}</div>
                            <div>{{ \Carbon\Carbon::parse($project->date_fin_prevue)->format('d/m/Y') }}</div>
                        </td>
                        <td>
                            @php
                                $statusClass = match($project->statut) {
                                    'planifié' => 'status-planned',
                                    'en_cours' => 'status-in-progress',
                                    'terminé' => 'status-completed',
                                    'suspendu' => 'status-suspended',
                                    'annulé' => 'status-cancelled',
                                    default => 'status-planned'
                                };
                            @endphp
                            <span class="minimal-badge {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $project->statut)) }}</span>
                        </td>
                        <td>
                            <div class="minimal-progress">
                                <div class="minimal-progress-bar" style="width: {{ $project->avancement_pourcentage }}%"></div>
                            </div>
                            <div style="font-size: 11px; color: #64748b; margin-top: 4px;">{{ $project->avancement_pourcentage }}%</div>
                        </td>
                        <td class="text-end">
                            <div class="d-flex gap-1 justify-content-end">
                                <a href="{{ route('admin.projects.show', $project) }}" class="minimal-btn minimal-btn-icon" title="Voir">
                                    <i class="fas fa-eye" style="font-size: 11px;"></i>
                                </a>
                                <a href="{{ route('admin.projects.edit', $project) }}" class="minimal-btn minimal-btn-icon" title="Modifier">
                                    <i class="fas fa-edit" style="font-size: 11px;"></i>
                                </a>
                                <button type="button" class="minimal-btn minimal-btn-icon" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $project->id }}" title="Supprimer" style="color: #ef4444; border-color: #fee2e2;">
                                    <i class="fas fa-trash" style="font-size: 11px;"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center" style="padding: 60px 20px;">
                            <i class="fas fa-folder-open" style="font-size: 48px; color: #e2e8f0; margin-bottom: 16px;"></i>
                            <p style="color: #94a3b8; margin-bottom: 16px;">Aucun projet trouvé.</p>
                            <a href="{{ route('admin.projects.create') }}" class="minimal-btn minimal-btn-primary">
                                <i class="fas fa-plus" style="margin-right: 8px; font-size: 11px;"></i>Créer le premier projet
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($projects->hasPages())
            <div style="padding: 20px; border-top: 1px solid #f1f5f9;">
                {{ $projects->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

{{-- Delete Modals --}}
@foreach($projects as $project)
    <div class="modal fade" id="deleteModal{{ $project->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
                <div class="modal-header border-0" style="padding: 24px 24px 16px;">
                    <h5 class="modal-title fw-semibold" style="color: #1e293b;">
                        <i class="fas fa-exclamation-triangle" style="color: #ef4444; margin-right: 8px;"></i>Confirmer la suppression
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding: 16px 24px 24px;">
                    <p style="color: #64748b; margin-bottom: 8px;">Êtes-vous sûr de vouloir supprimer le projet <strong style="color: #1e293b;">"{{ $project->titre }}"</strong> ?</p>
                    <p style="font-size: 13px; color: #94a3b8; margin-bottom: 0;">Cette action est irréversible.</p>
                </div>
                <div class="modal-footer border-0" style="padding: 0 24px 24px;">
                    <button type="button" class="minimal-btn minimal-btn-ghost" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="minimal-btn" style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);">
                            <i class="fas fa-trash" style="margin-right: 8px; font-size: 11px;"></i>Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
