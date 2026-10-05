@php
use Carbon\Carbon;
@endphp

<x-project.layouts.front 
    title="Mes Dons"
    :hero="[
        'title' => 'Mes Contributions',
        'subtitle' => 'Suivez l\'impact de vos dons sur les projets de rénovation',
        'background' => 'linear-gradient(135deg, var(--ocean) 0%, var(--aqua) 100%)'
    ]">

    {{-- Statistiques personnelles --}}
    <div class="aq-stats-grid" style="margin-bottom: 3rem;">
        <div class="aq-stat-card">
            <div class="aq-stat-icon" style="background: var(--ocean);">
                <svg fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="aq-stat-info">
                <div class="aq-stat-label">Total des Dons</div>
                <div class="aq-stat-value">{{ number_format($donations->sum('montant'), 0, ',', ' ') }} €</div>
            </div>
        </div>

        <div class="aq-stat-card">
            <div class="aq-stat-icon" style="background: var(--success);">
                <svg fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="aq-stat-info">
                <div class="aq-stat-label">Confirmés</div>
                <div class="aq-stat-value">{{ $donations->where('statut', 'confirmé')->count() }}</div>
            </div>
        </div>

        <div class="aq-stat-card">
            <div class="aq-stat-icon" style="background: var(--warning);">
                <svg fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="aq-stat-info">
                <div class="aq-stat-label">En attente</div>
                <div class="aq-stat-value">{{ $donations->where('statut', 'en_attente')->count() }}</div>
            </div>
        </div>

        <div class="aq-stat-card">
            <div class="aq-stat-icon" style="background: var(--aqua);">
                <svg fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="aq-stat-info">
                <div class="aq-stat-label">Projets Soutenus</div>
                <div class="aq-stat-value">{{ $donations->pluck('project_id')->unique()->count() }}</div>
            </div>
        </div>
    </div>

    {{-- Filtres --}}
    <div class="aq-card" style="margin-bottom: 2rem;">
        <form method="GET" action="{{ route('my-donations') }}" class="aq-filters-form">
            <div class="aq-form-row">
                <div class="aq-form-group">
                    <select name="statut" class="aq-form-control">
                        <option value="">Tous les statuts</option>
                        <option value="confirmé" {{ request('statut') === 'confirmé' ? 'selected' : '' }}>Confirmé</option>
                        <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="refusé" {{ request('statut') === 'refusé' ? 'selected' : '' }}>Refusé</option>
                    </select>
                </div>

                <button type="submit" class="aq-btn aq-btn-primary">
                    Filtrer
                </button>
                
                @if(request()->has('statut'))
                    <a href="{{ route('my-donations') }}" class="aq-btn aq-btn-outline">
                        Réinitialiser
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Liste des dons --}}
    @if($donations->count() > 0)
        <div class="aq-card">
            <div class="aq-card-header">
                <div>
                    <h2 class="aq-card-title">Historique de mes Dons</h2>
                    <p class="aq-card-subtitle">{{ $donations->count() }} contribution(s)</p>
                </div>
            </div>

            <div class="aq-donations-list">
                @foreach($donations as $donation)
                    <div class="aq-donation-item">
                        <div class="aq-donation-header">
                            <div>
                                <h3 class="aq-donation-title">
                                    <a href="{{ route('projects.show', $donation->project) }}">
                                        {{ $donation->project->titre }}
                                    </a>
                                </h3>
                                <p class="aq-donation-meta">
                                    <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ Carbon::parse($donation->date_obtention)->format('d/m/Y à H:i') }}
                                </p>
                            </div>
                            <div class="aq-donation-amount">{{ number_format($donation->montant, 0, ',', ' ') }} €</div>
                        </div>

                        @if($donation->description)
                            <div class="aq-donation-message">
                                <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                </svg>
                                <p>{{ $donation->description }}</p>
                            </div>
                        @endif

                        <div class="aq-donation-footer">
                            <div>
                                @php
                                    $statutBadge = match($donation->statut) {
                                        'confirmé' => 'aq-badge-success',
                                        'en_attente' => 'aq-badge-warning',
                                        'refusé' => 'aq-badge-danger',
                                        default => 'aq-badge-secondary'
                                    };
                                @endphp
                                <span class="aq-badge {{ $statutBadge }}">
                                    {{ ucfirst(str_replace('_', ' ', $donation->statut)) }}
                                </span>

                                @if($donation->statut === 'confirmé')
                                    <span class="aq-badge aq-badge-info">
                                        <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Reçu fiscal disponible
                                    </span>
                                @endif
                            </div>

                            <a href="{{ route('projects.show', $donation->project) }}" class="aq-btn aq-btn-outline aq-btn-sm">
                                Voir le projet
                            </a>
                        </div>

                        @if($donation->statut === 'confirmé')
                            {{-- Progression du projet --}}
                            <div class="aq-donation-progress">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <span class="aq-label">Avancement du projet</span>
                                    <strong>{{ $donation->project->avancement_pourcentage }}%</strong>
                                </div>
                                <div class="aq-progress">
                                    <div class="aq-progress-bar" style="width: {{ $donation->project->avancement_pourcentage }}%"></div>
                                </div>
                            </div>
                        @endif

                        @if($donation->statut === 'en_attente')
                            <div class="aq-alert aq-alert-info" style="margin-top: 1rem;">
                                <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p>Votre don est en cours de vérification par un administrateur. Vous serez notifié dès sa validation.</p>
                            </div>
                        @endif

                        @if($donation->statut === 'refusé')
                            <div class="aq-alert aq-alert-danger" style="margin-top: 1rem;">
                                <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p>Votre don a été refusé. Pour plus d'informations, veuillez contacter l'administration.</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Impact total --}}
        @if($donations->where('statut', 'confirmé')->count() > 0)
            <div class="aq-card" style="margin-top: 2rem; background: linear-gradient(135deg, var(--ocean) 0%, var(--aqua) 100%); color: white;">
                <div style="text-align: center; padding: 2rem;">
                    <svg class="aq-icon" style="width: 48px; height: 48px; margin: 0 auto 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">Merci pour votre générosité !</h2>
                    <p style="font-size: 1.125rem; opacity: 0.9;">
                        Vos contributions ont un impact réel sur l'amélioration des infrastructures hydrauliques.<br>
                        Ensemble, nous construisons un avenir meilleur.
                    </p>
                </div>
            </div>
        @endif

    @else
        {{-- État vide --}}
        <div class="aq-card" style="text-align: center; padding: 4rem 2rem;">
            <svg class="aq-icon" style="width: 80px; height: 80px; margin: 0 auto 1.5rem; color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <h3 style="color: var(--navy); font-size: 1.5rem; margin-bottom: 1rem;">Vous n'avez pas encore fait de don</h3>
            <p style="color: var(--text-muted); font-size: 1.125rem; margin-bottom: 2rem;">
                Découvrez les projets de rénovation et soutenez ceux qui vous tiennent à cœur
            </p>
            <a href="{{ route('projects.index') }}" class="aq-btn aq-btn-primary">
                <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Découvrir les projets
            </a>
        </div>
    @endif

    @push('styles')
    <style>
        .aq-donations-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .aq-donation-item {
            padding: 1.5rem;
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            background: white;
            transition: box-shadow 0.2s;
        }

        .aq-donation-item:hover {
            box-shadow: 0 4px 12px rgba(11, 37, 69, 0.1);
        }

        .aq-donation-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .aq-donation-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 0.5rem;
        }

        .aq-donation-title a {
            color: inherit;
            text-decoration: none;
        }

        .aq-donation-title a:hover {
            color: var(--ocean);
        }

        .aq-donation-meta {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        .aq-donation-meta .aq-icon {
            width: 16px;
            height: 16px;
        }

        .aq-donation-amount {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--ocean);
        }

        .aq-donation-message {
            display: flex;
            gap: 0.75rem;
            padding: 1rem;
            background: var(--bg);
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .aq-donation-message .aq-icon {
            width: 20px;
            height: 20px;
            color: var(--ocean);
            flex-shrink: 0;
        }

        .aq-donation-message p {
            color: var(--text-secondary);
            font-style: italic;
            line-height: 1.6;
        }

        .aq-donation-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .aq-donation-progress {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border);
        }

        @media (max-width: 768px) {
            .aq-donation-header {
                flex-direction: column;
                gap: 1rem;
            }

            .aq-donation-amount {
                align-self: flex-start;
            }

            .aq-donation-footer {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
    @endpush

</x-project.layouts.front>
