@php
use Carbon\Carbon;
@endphp

<x-project.layouts.front 
    title="{{ $project->titre }}"
    :hero="[
        'title' => $project->titre,
        'subtitle' => $project->zone->nom . ' • ' . ucfirst($project->type),
        'background' => 'linear-gradient(135deg, var(--ocean) 0%, var(--aqua) 100%)'
    ]">

    <div class="aq-grid-3">
        {{-- Colonne principale (2 colonnes) --}}
        <div style="grid-column: span 2;">
            {{-- Informations générales --}}
            <div class="aq-card">
                <div class="aq-card-header">
                    <div>
                        <h2 class="aq-card-title">Détails du Projet</h2>
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
                        <div style="margin-top: 0.5rem;">
                            <span class="aq-badge {{ $badgeClass }}">
                                {{ ucfirst(str_replace('_', ' ', $project->statut)) }}
                            </span>
                            <span class="aq-badge aq-badge-info">{{ ucfirst($project->type) }}</span>
                        </div>
                    </div>
                </div>

                <div class="aq-grid-2" style="margin-bottom: 1.5rem;">
                    <div>
                        <h3 style="font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">
                            <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: inline-block; vertical-align: middle;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Localisation
                        </h3>
                        <p><strong>Zone:</strong> {{ $project->zone->nom ?? 'Non définie' }}</p>
                        <p><strong>Infrastructure:</strong> {{ $project->infrastructure->nom ?? 'Non définie' }}</p>
                        @if($project->infrastructure)
                            <p class="aq-text-muted">{{ ucfirst($project->infrastructure->type) }}</p>
                        @endif
                    </div>

                    <div>
                        <h3 style="font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">
                            <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: inline-block; vertical-align: middle;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Calendrier
                        </h3>
                        <p><strong>Début:</strong> {{ Carbon::parse($project->date_debut)->format('d/m/Y') }}</p>
                        <p><strong>Fin prévue:</strong> {{ Carbon::parse($project->date_fin_prevue)->format('d/m/Y') }}</p>
                        @php
                            $now = Carbon::now();
                            $finPrevue = Carbon::parse($project->date_fin_prevue);
                            $joursRestants = $now->diffInDays($finPrevue, false);
                        @endphp
                        @if($project->statut === 'en_cours')
                            @if($joursRestants < 0)
                                <span class="aq-badge aq-badge-danger">Retard de {{ abs($joursRestants) }} jours</span>
                            @elseif($joursRestants <= 30)
                                <span class="aq-badge aq-badge-warning">{{ $joursRestants }} jours restants</span>
                            @else
                                <span class="aq-badge aq-badge-success">{{ $joursRestants }} jours restants</span>
                            @endif
                        @endif
                    </div>
                </div>

                <div>
                    <h3 style="font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Description</h3>
                    <p style="color: var(--text-secondary); line-height: 1.7;">{{ $project->description }}</p>
                </div>

                <div style="margin-top: 1.5rem;">
                    <h3 style="font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">
                        Avancement du projet: {{ $project->avancement_pourcentage }}%
                    </h3>
                    <div class="aq-progress" style="height: 2rem;">
                        <div class="aq-progress-bar" style="width: {{ $project->avancement_pourcentage }}%">
                            {{ $project->avancement_pourcentage }}%
                        </div>
                    </div>
                </div>
            </div>

            {{-- Phases du projet --}}
            @if($project->projectPhases->count() > 0)
                <div class="aq-card" style="margin-top: 1.5rem;">
                    <div class="aq-card-header">
                        <div>
                            <h2 class="aq-card-title">Phases du Projet</h2>
                            <p class="aq-card-subtitle">{{ $project->projectPhases->count() }} phase(s) planifiée(s)</p>
                        </div>
                    </div>

                    <div class="aq-timeline">
                        @foreach($project->projectPhases->sortBy('date_debut') as $index => $phase)
                            <div class="aq-timeline-item">
                                <div class="aq-timeline-marker">
                                    <div class="aq-timeline-number">{{ $index + 1 }}</div>
                                </div>
                                <div class="aq-timeline-content">
                                    <h4>{{ $phase->nom }}</h4>
                                    <div class="aq-timeline-meta">
                                        @if($phase->contractor)
                                            <span>
                                                <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                                {{ $phase->contractor->nom }}
                                            </span>
                                        @endif
                                        <span>
                                            <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            {{ Carbon::parse($phase->date_debut)->format('d/m/Y') }} - {{ Carbon::parse($phase->date_fin)->format('d/m/Y') }}
                                        </span>
                                        <span>
                                            <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ number_format($phase->cout, 0, ',', ' ') }} €
                                        </span>
                                    </div>
                                    <div class="aq-progress" style="margin-top: 0.5rem;">
                                        <div class="aq-progress-bar" style="width: {{ $phase->avancement }}%"></div>
                                    </div>
                                    <small class="aq-text-muted">{{ $phase->avancement }}% complété</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Documents --}}
            @if($project->projectDocuments->count() > 0)
                <div class="aq-card" style="margin-top: 1.5rem;">
                    <div class="aq-card-header">
                        <div>
                            <h2 class="aq-card-title">Documents</h2>
                            <p class="aq-card-subtitle">{{ $project->projectDocuments->count() }} document(s) disponible(s)</p>
                        </div>
                    </div>

                    <div class="aq-grid-2">
                        @foreach($project->projectDocuments as $document)
                            <div class="aq-document-card">
                                <div class="aq-document-icon">
                                    <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="aq-document-info">
                                    <h4>{{ $document->nom }}</h4>
                                    <p class="aq-text-muted">{{ ucfirst($document->type_document) }}</p>
                                    @if($document->description)
                                        <p style="font-size: 0.875rem; margin-top: 0.5rem;">{{ $document->description }}</p>
                                    @endif
                                </div>
                                <div class="aq-document-actions">
                                    <a href="{{ Storage::url($document->chemin_fichier) }}" 
                                       class="aq-btn aq-btn-outline aq-btn-sm" 
                                       download>
                                        <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                        Télécharger
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Colonne latérale (1 colonne) --}}
        <div>
            {{-- Budget et financement --}}
            <div class="aq-card aq-sticky-card">
                <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--navy); margin-bottom: 1.5rem;">
                    Budget et Financement
                </h3>

                <div class="aq-budget-info">
                    <div class="aq-budget-item">
                        <div class="aq-budget-label">Budget prévu</div>
                        <div class="aq-budget-value">{{ number_format($project->budget_prevu, 0, ',', ' ') }} €</div>
                    </div>

                    <div class="aq-budget-item">
                        <div class="aq-budget-label">Financement obtenu</div>
                        <div class="aq-budget-value" style="color: var(--success);">
                            {{ number_format($project->fundingTotal(), 0, ',', ' ') }} €
                        </div>
                        @php
                            $tauxFinancement = $project->budget_prevu > 0 ? ($project->fundingTotal() / $project->budget_prevu) * 100 : 0;
                        @endphp
                        <div class="aq-progress" style="margin-top: 0.5rem;">
                            <div class="aq-progress-bar" style="width: {{ min($tauxFinancement, 100) }}%"></div>
                        </div>
                        <small class="aq-text-muted">{{ number_format($tauxFinancement, 1) }}% du budget</small>
                    </div>

                    <div class="aq-budget-item">
                        <div class="aq-budget-label">Budget restant</div>
                        <div class="aq-budget-value" style="color: {{ $project->budgetRemaining() < 0 ? 'var(--danger)' : 'var(--text)' }}">
                            {{ number_format($project->budgetRemaining(), 0, ',', ' ') }} €
                        </div>
                        @if($project->budgetRemaining() < 0)
                            <span class="aq-badge aq-badge-danger" style="margin-top: 0.5rem;">Dépassement</span>
                        @endif
                    </div>
                </div>

                {{-- CTA pour faire un don --}}
                @auth
                    @if(auth()->user()->role === 'citoyen')
                        <a href="{{ route('projects.donate', $project) }}" 
                           class="aq-btn aq-btn-primary aq-btn-block" 
                           style="margin-top: 1.5rem;">
                            <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            Faire un don
                        </a>
                    @endif
                @else
                    <p class="aq-text-muted" style="margin-top: 1.5rem; text-align: center; font-size: 0.875rem;">
                        <a href="{{ route('login') }}" style="color: var(--ocean); font-weight: 600;">Connectez-vous</a> pour soutenir ce projet
                    </p>
                @endauth
            </div>

            {{-- Sources de financement --}}
            @if($project->fundings->count() > 0)
                <div class="aq-card" style="margin-top: 1.5rem;">
                    <h3 style="font-size: 1rem; font-weight: 600; color: var(--navy); margin-bottom: 1rem;">
                        Sources de Financement
                    </h3>

                    <div class="aq-funding-list">
                        @foreach($project->fundings->where('statut', 'confirmé') as $funding)
                            <div class="aq-funding-item">
                                <div class="aq-funding-icon">
                                    @if($funding->source === 'don')
                                        <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                    @else
                                        <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="aq-funding-details">
                                    <div class="aq-funding-source">{{ ucfirst($funding->source) }}</div>
                                    <div class="aq-funding-amount">{{ number_format($funding->montant, 0, ',', ' ') }} €</div>
                                    <small class="aq-text-muted">{{ Carbon::parse($funding->date_obtention)->format('d/m/Y') }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Retour --}}
            <a href="{{ route('projects.index') }}" 
               class="aq-btn aq-btn-outline aq-btn-block" 
               style="margin-top: 1.5rem;">
                <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour à la liste
            </a>
        </div>
    </div>

</x-project.layouts.front>
