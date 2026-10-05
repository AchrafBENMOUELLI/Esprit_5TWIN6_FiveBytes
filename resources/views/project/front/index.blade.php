@php
use Carbon\Carbon;
@endphp

<x-project.layouts.front 
    title="Projets de Rénovation"
    :hero="[
        'title' => 'Projets de Rénovation',
        'subtitle' => 'Découvrez les projets de rénovation et de modernisation des infrastructures hydrauliques',
        'background' => 'linear-gradient(135deg, var(--ocean) 0%, var(--aqua) 100%)'
    ]">

    {{-- Filtres et recherche --}}
    <div class="aq-card" style="margin-bottom: 2rem;">
        <form method="GET" action="{{ route('projects.index') }}" class="aq-filters-form">
            <div class="aq-form-row">
                <div class="aq-form-group">
                    <input type="text" 
                           name="search" 
                           class="aq-form-control" 
                           placeholder="Rechercher un projet..." 
                           value="{{ request('search') }}">
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

                <div class="aq-form-group">
                    <select name="statut" class="aq-form-control">
                        <option value="">Tous les statuts</option>
                        <option value="planifié" {{ request('statut') === 'planifié' ? 'selected' : '' }}>Planifié</option>
                        <option value="en_cours" {{ request('statut') === 'en_cours' ? 'selected' : '' }}>En cours</option>
                        <option value="terminé" {{ request('statut') === 'terminé' ? 'selected' : '' }}>Terminé</option>
                    </select>
                </div>

                <button type="submit" class="aq-btn aq-btn-primary">
                    Rechercher
                </button>
                
                @if(request()->hasAny(['search', 'type', 'statut']))
                    <a href="{{ route('projects.index') }}" class="aq-btn aq-btn-outline">
                        Réinitialiser
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Statistiques --}}
    <div class="aq-stats-grid" style="margin-bottom: 3rem;">
        <div class="aq-stat-card">
            <div class="aq-stat-icon" style="background: var(--ocean);">
                <svg fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="aq-stat-info">
                <div class="aq-stat-label">Total Projets</div>
                <div class="aq-stat-value">{{ $projects->total() }}</div>
            </div>
        </div>

        <div class="aq-stat-card">
            <div class="aq-stat-icon" style="background: var(--aqua);">
                <svg fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div class="aq-stat-info">
                <div class="aq-stat-label">En cours</div>
                <div class="aq-stat-value">{{ $projects->where('statut', 'en_cours')->count() }}</div>
            </div>
        </div>

        <div class="aq-stat-card">
            <div class="aq-stat-icon" style="background: var(--success);">
                <svg fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="aq-stat-info">
                <div class="aq-stat-label">Terminés</div>
                <div class="aq-stat-value">{{ $projects->where('statut', 'terminé')->count() }}</div>
            </div>
        </div>

        <div class="aq-stat-card">
            <div class="aq-stat-icon" style="background: var(--warning);">
                <svg fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="aq-stat-info">
                <div class="aq-stat-label">Budget Total</div>
                <div class="aq-stat-value">{{ number_format($projects->sum('budget_prevu') / 1000000, 1) }}M €</div>
            </div>
        </div>
    </div>

    {{-- Liste des projets --}}
    <div class="aq-grid-3">
        @forelse($projects as $project)
            <div class="aq-card aq-project-card">
                {{-- En-tête --}}
                <div class="aq-project-header">
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
                    <span class="aq-badge aq-badge-info">{{ ucfirst($project->type) }}</span>
                </div>

                {{-- Contenu --}}
                <h3 class="aq-project-title">{{ $project->titre }}</h3>
                <p class="aq-project-description">{{ Str::limit($project->description, 120) }}</p>

                {{-- Informations --}}
                <div class="aq-project-info">
                    <div class="aq-info-item">
                        <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>{{ $project->zone->nom ?? 'Non défini' }}</span>
                    </div>
                    
                    <div class="aq-info-item">
                        <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ Carbon::parse($project->date_debut)->format('d/m/Y') }}</span>
                    </div>
                </div>

                {{-- Budget --}}
                <div class="aq-project-budget">
                    <div>
                        <span class="aq-label">Budget:</span>
                        <strong>{{ number_format($project->budget_prevu, 0, ',', ' ') }} €</strong>
                    </div>
                    @if($project->fundings->count() > 0)
                        <div style="font-size: 0.875rem; color: var(--success);">
                            <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ number_format(($project->fundingTotal() / $project->budget_prevu) * 100, 0) }}% financé
                        </div>
                    @endif
                </div>

                {{-- Avancement --}}
                <div class="aq-project-progress">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span class="aq-label">Avancement</span>
                        <strong>{{ $project->avancement_pourcentage }}%</strong>
                    </div>
                    <div class="aq-progress">
                        <div class="aq-progress-bar" style="width: {{ $project->avancement_pourcentage }}%"></div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="aq-project-actions">
                    <a href="{{ route('projects.show', $project) }}" class="aq-btn aq-btn-primary aq-btn-block">
                        Voir les détails
                    </a>
                    @auth
                        @if(auth()->user()->role === 'citoyen')
                            <a href="{{ route('projects.donate', $project) }}" class="aq-btn aq-btn-outline aq-btn-block">
                                <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                Faire un don
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        @empty
            <div class="aq-card" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                <svg class="aq-icon" style="width: 64px; height: 64px; margin: 0 auto 1rem; color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 style="color: var(--navy); margin-bottom: 0.5rem;">Aucun projet trouvé</h3>
                <p style="color: var(--text-muted);">Essayez de modifier vos critères de recherche.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($projects->hasPages())
        <div style="margin-top: 3rem; display: flex; justify-content: center;">
            {{ $projects->links() }}
        </div>
    @endif

    {{-- Section CTA pour les citoyens connectés --}}
    @auth
        @if(auth()->user()->role === 'citoyen')
            <div class="aq-cta-section" style="margin-top: 4rem;">
                <div class="aq-card" style="background: linear-gradient(135deg, var(--ocean) 0%, var(--aqua) 100%); color: white; text-align: center; padding: 3rem;">
                    <svg class="aq-icon" style="width: 48px; height: 48px; margin: 0 auto 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">Soutenez les projets de rénovation</h2>
                    <p style="font-size: 1.125rem; margin-bottom: 2rem; opacity: 0.9;">
                        Votre contribution permet de moderniser les infrastructures hydrauliques et d'améliorer l'accès à l'eau potable.
                    </p>
                    <a href="{{ route('my-donations') }}" class="aq-btn" style="background: white; color: var(--ocean); font-weight: 600;">
                        Voir mes dons
                    </a>
                </div>
            </div>
        @endif
    @endauth

</x-project.layouts.front>
