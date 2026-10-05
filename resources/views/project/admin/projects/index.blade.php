@php
use App\Models\Project\Project;
@endphp

<x-project.layouts.admin 
    title="Gestion des Projets"
    :breadcrumbs="[
        ['label' => 'Tableau de bord', 'url' => route('admin.dashboard')],
        ['label' => 'Projets', 'url' => null]
    ]">

    <div class="aq-card">
        <div class="aq-card-header">
            <div>
                <h2 class="aq-card-title">Liste des Projets de Rénovation</h2>
                <p class="aq-card-subtitle">Gérer et suivre tous les projets de rénovation d'infrastructures</p>
            </div>
            <a href="{{ route('admin.projects.create') }}" class="aq-btn aq-btn-primary">
                <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nouveau Projet
            </a>
        </div>

        {{-- Filtres --}}
        <div class="aq-filters">
            <form method="GET" action="{{ route('admin.projects.index') }}" class="aq-filters-form">
                <div class="aq-form-row">
                    <div class="aq-form-group">
                        <input type="text" name="search" class="aq-form-control" 
                               placeholder="Rechercher un projet..." 
                               value="{{ request('search') }}">
                    </div>
                    
                    <div class="aq-form-group">
                        <select name="statut" class="aq-form-control">
                            <option value="">Tous les statuts</option>
                            <option value="planifié" {{ request('statut') === 'planifié' ? 'selected' : '' }}>Planifié</option>
                            <option value="en_cours" {{ request('statut') === 'en_cours' ? 'selected' : '' }}>En cours</option>
                            <option value="terminé" {{ request('statut') === 'terminé' ? 'selected' : '' }}>Terminé</option>
                            <option value="suspendu" {{ request('statut') === 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                            <option value="annulé" {{ request('statut') === 'annulé' ? 'selected' : '' }}>Annulé</option>
                        </select>
                    </div>

                    <div class="aq-form-group">
                        <select name="type" class="aq-form-control">
                            <option value="">Tous les types</option>
                            <option value="réparation" {{ request('type') === 'réparation' ? 'selected' : '' }}>Réparation</option>
                            <option value="modernisation" {{ request('type') === 'modernisation' ? 'selected' : '' }}>Modernisation</option>
                            <option value="extension" {{ request('type') === 'extension' ? 'selected' : '' }}>Extension</option>
                            <option value="construction" {{ request('type') === 'construction' ? 'selected' : '' }}>Construction</option>
                        </select>
                    </div>

                    <button type="submit" class="aq-btn aq-btn-secondary">
                        Filtrer
                    </button>
                    
                    @if(request()->hasAny(['search', 'statut', 'type']))
                        <a href="{{ route('admin.projects.index') }}" class="aq-btn aq-btn-outline">
                            Réinitialiser
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Statistiques rapides --}}
        <div class="aq-grid-4" style="margin-bottom: 2rem;">
            <div class="aq-stat-card">
                <div class="aq-stat-label">Total Projets</div>
                <div class="aq-stat-value">{{ $projects->total() }}</div>
            </div>
            <div class="aq-stat-card">
                <div class="aq-stat-label">En cours</div>
                <div class="aq-stat-value">{{ $projects->where('statut', 'en_cours')->count() }}</div>
            </div>
            <div class="aq-stat-card">
                <div class="aq-stat-label">Budget Total</div>
                <div class="aq-stat-value">{{ number_format($projects->sum('budget_prevu'), 0, ',', ' ') }} €</div>
            </div>
            <div class="aq-stat-card">
                <div class="aq-stat-label">Terminés</div>
                <div class="aq-stat-value">{{ $projects->where('statut', 'terminé')->count() }}</div>
            </div>
        </div>

        {{-- Table --}}
        <div class="aq-table-responsive">
            <table class="aq-table">
                <thead>
                    <tr>
                        <th>Projet</th>
                        <th>Type</th>
                        <th>Zone / Infrastructure</th>
                        <th>Budget</th>
                        <th>Dates</th>
                        <th>Statut</th>
                        <th>Avancement</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                        <tr>
                            <td>
                                <div class="aq-table-title">{{ $project->titre }}</div>
                                <div class="aq-table-subtitle">Responsable: {{ $project->responsable->name ?? 'Non assigné' }}</div>
                            </td>
                            <td>
                                <span class="aq-badge aq-badge-info">{{ ucfirst($project->type) }}</span>
                            </td>
                            <td>
                                <div class="aq-table-subtitle">
                                    {{ $project->zone->nom ?? 'N/A' }}<br>
                                    <small>{{ $project->infrastructure->nom ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td>
                                <strong>{{ number_format($project->budget_prevu, 0, ',', ' ') }} €</strong>
                                @if($project->fundings->count() > 0)
                                    <div class="aq-table-subtitle">
                                        Financé: {{ number_format($project->fundingTotal(), 0, ',', ' ') }} €
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="aq-table-subtitle">
                                    {{ \Carbon\Carbon::parse($project->date_debut)->format('d/m/Y') }}<br>
                                    <small>→ {{ \Carbon\Carbon::parse($project->date_fin_prevue)->format('d/m/Y') }}</small>
                                </div>
                            </td>
                            <td>
                                @php
                                    $badgeClass = match($project->statut) {
                                        'planifié' => 'aq-badge-secondary',
                                        'en_cours' => 'aq-badge-primary',
                                        'terminé' => 'aq-badge-success',
                                        'suspendu' => 'aq-badge-warning',
                                        'annulé' => 'aq-badge-danger',
                                        default => 'aq-badge-secondary'
                                    };
                                @endphp
                                <span class="aq-badge {{ $badgeClass }}">
                                    {{ ucfirst(str_replace('_', ' ', $project->statut)) }}
                                </span>
                            </td>
                            <td>
                                <div class="aq-progress">
                                    <div class="aq-progress-bar" style="width: {{ $project->avancement_pourcentage }}%"></div>
                                </div>
                                <div class="aq-table-subtitle">{{ $project->avancement_pourcentage }}%</div>
                            </td>
                            <td>
                                <div class="aq-actions">
                                    <a href="{{ route('admin.projects.show', $project) }}" 
                                       class="aq-btn-icon" 
                                       title="Voir les détails">
                                        <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.projects.edit', $project) }}" 
                                       class="aq-btn-icon" 
                                       title="Modifier">
                                        <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.projects.destroy', $project) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="aq-btn-icon aq-btn-danger" title="Supprimer">
                                            <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="aq-table-empty">
                                <svg class="aq-icon" style="width: 48px; height: 48px; margin-bottom: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p>Aucun projet trouvé.</p>
                                <a href="{{ route('admin.projects.create') }}" class="aq-btn aq-btn-primary" style="margin-top: 1rem;">
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
            <div class="aq-pagination">
                {{ $projects->links() }}
            </div>
        @endif
    </div>

</x-project.layouts.admin>
