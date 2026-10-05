@php
use App\Models\Project\Contractor;
@endphp

<x-project.layouts.admin 
    title="Gestion des Contractants"
    :breadcrumbs="[
        ['label' => 'Tableau de bord', 'url' => route('admin.dashboard')],
        ['label' => 'Contractants', 'url' => null]
    ]">

    <div class="aq-card">
        <div class="aq-card-header">
            <div>
                <h2 class="aq-card-title">Liste des Contractants</h2>
                <p class="aq-card-subtitle">Gérer les entreprises et contractants pour les phases de projet</p>
            </div>
            <a href="{{ route('admin.contractors.create') }}" class="aq-btn aq-btn-primary">
                <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nouveau Contractant
            </a>
        </div>

        {{-- Filtres --}}
        <div class="aq-filters">
            <form method="GET" action="{{ route('admin.contractors.index') }}" class="aq-filters-form">
                <div class="aq-form-row">
                    <div class="aq-form-group">
                        <input type="text" name="search" class="aq-form-control" 
                               placeholder="Rechercher un contractant..." 
                               value="{{ request('search') }}">
                    </div>
                    
                    <div class="aq-form-group">
                        <input type="text" name="specialite" class="aq-form-control" 
                               placeholder="Spécialité..." 
                               value="{{ request('specialite') }}">
                    </div>

                    <button type="submit" class="aq-btn aq-btn-secondary">
                        Filtrer
                    </button>
                    
                    @if(request()->hasAny(['search', 'specialite']))
                        <a href="{{ route('admin.contractors.index') }}" class="aq-btn aq-btn-outline">
                            Réinitialiser
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Statistiques rapides --}}
        <div class="aq-grid-4" style="margin-bottom: 2rem;">
            <div class="aq-stat-card">
                <div class="aq-stat-label">Total Contractants</div>
                <div class="aq-stat-value">{{ $contractors->total() }}</div>
            </div>
            <div class="aq-stat-card">
                <div class="aq-stat-label">Actifs</div>
                <div class="aq-stat-value">{{ $contractors->where('projectPhases_count', '>', 0)->count() }}</div>
            </div>
            <div class="aq-stat-card">
                <div class="aq-stat-label">Phases Totales</div>
                <div class="aq-stat-value">{{ $contractors->sum('projectPhases_count') }}</div>
            </div>
            <div class="aq-stat-card">
                <div class="aq-stat-label">Spécialités</div>
                <div class="aq-stat-value">{{ $contractors->pluck('specialite')->unique()->count() }}</div>
            </div>
        </div>

        {{-- Table --}}
        <div class="aq-table-responsive">
            <table class="aq-table">
                <thead>
                    <tr>
                        <th>Contractant</th>
                        <th>Contact</th>
                        <th>Spécialité</th>
                        <th>Phases Actives</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contractors as $contractor)
                        <tr>
                            <td>
                                <div class="aq-table-title">{{ $contractor->nom }}</div>
                                @if($contractor->adresse)
                                    <div class="aq-table-subtitle">{{ $contractor->adresse }}</div>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                    @if($contractor->telephone)
                                        <div class="aq-info-item">
                                            <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            <span style="font-size: 0.875rem;">{{ $contractor->telephone }}</span>
                                        </div>
                                    @endif
                                    @if($contractor->email)
                                        <div class="aq-info-item">
                                            <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            <span style="font-size: 0.875rem;">{{ $contractor->email }}</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="aq-badge aq-badge-info">{{ ucfirst($contractor->specialite) }}</span>
                            </td>
                            <td>
                                <strong style="font-size: 1.25rem; color: var(--ocean);">{{ $contractor->projectPhases_count ?? 0 }}</strong>
                                @if($contractor->projectPhases_count > 0)
                                    <div class="aq-table-subtitle">phase(s) en cours</div>
                                @else
                                    <div class="aq-table-subtitle" style="color: var(--text-muted);">Aucune phase</div>
                                @endif
                            </td>
                            <td>
                                <div class="aq-actions">
                                    <a href="{{ route('admin.contractors.show', $contractor) }}" 
                                       class="aq-btn-icon" 
                                       title="Voir les détails">
                                        <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.contractors.edit', $contractor) }}" 
                                       class="aq-btn-icon" 
                                       title="Modifier">
                                        <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.contractors.destroy', $contractor) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce contractant ?');">
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
                            <td colspan="5" class="aq-table-empty">
                                <svg class="aq-icon" style="width: 48px; height: 48px; margin-bottom: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <p>Aucun contractant trouvé.</p>
                                <a href="{{ route('admin.contractors.create') }}" class="aq-btn aq-btn-primary" style="margin-top: 1rem;">
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
            <div class="aq-pagination">
                {{ $contractors->links() }}
            </div>
        @endif
    </div>

</x-project.layouts.admin>
