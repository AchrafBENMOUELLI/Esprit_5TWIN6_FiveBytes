@extends('components.project.layouts.front')

@section('title', 'Projets de Rénovation')

@section('content')
{{-- Hero Section --}}
<div class="hero-section bg-gradient text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="fas fa-water me-3"></i>
                    Projets de Rénovation
                </h1>
                <p class="lead mb-4">
                    Découvrez et soutenez les projets de modernisation des infrastructures hydrauliques. 
                    Ensemble, construisons un avenir durable pour l'accès à l'eau potable.
                </p>
                <div class="d-flex gap-3">
                    <div class="stat-box">
                        <h3 class="mb-0">{{ $projects->total() }}</h3>
                        <small>Projets</small>
                    </div>
                    <div class="stat-box">
                        <h3 class="mb-0">{{ $projects->where('statut', 'en_cours')->count() }}</h3>
                        <small>En cours</small>
                    </div>
                    <div class="stat-box">
                        <h3 class="mb-0">{{ $projects->where('statut', 'terminé')->count() }}</h3>
                        <small>Terminés</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 text-center d-none d-lg-block">
                <i class="fas fa-city opacity-25" style="font-size: 15rem;"></i>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    {{-- Filtres --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('projects.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">
                        <i class="fas fa-search me-1"></i> Recherche
                    </label>
                    <input type="text" 
                           class="form-control" 
                           id="search" 
                           name="search" 
                           placeholder="Nom du projet..." 
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <label for="zone_id" class="form-label">
                        <i class="fas fa-map-marker-alt me-1"></i> Zone
                    </label>
                    <select class="form-select" id="zone_id" name="zone_id">
                        <option value="">Toutes les zones</option>
                        @foreach(\App\Models\Infrastructure\Zone::all() as $zone)
                            <option value="{{ $zone->id }}" {{ request('zone_id') == $zone->id ? 'selected' : '' }}>
                                {{ $zone->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="type" class="form-label">
                        <i class="fas fa-tools me-1"></i> Type
                    </label>
                    <select class="form-select" id="type" name="type">
                        <option value="">Tous</option>
                        <option value="réparation" {{ request('type') === 'réparation' ? 'selected' : '' }}>Réparation</option>
                        <option value="modernisation" {{ request('type') === 'modernisation' ? 'selected' : '' }}>Modernisation</option>
                        <option value="extension" {{ request('type') === 'extension' ? 'selected' : '' }}>Extension</option>
                        <option value="construction" {{ request('type') === 'construction' ? 'selected' : '' }}>Construction</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="statut" class="form-label">
                        <i class="fas fa-flag me-1"></i> Statut
                    </label>
                    <select class="form-select" id="statut" name="statut">
                        <option value="">Tous</option>
                        <option value="planifié" {{ request('statut') === 'planifié' ? 'selected' : '' }}>Planifié</option>
                        <option value="en_cours" {{ request('statut') === 'en_cours' ? 'selected' : '' }}>En cours</option>
                        <option value="terminé" {{ request('statut') === 'terminé' ? 'selected' : '' }}>Terminé</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-1"></i> Filtrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Grille de projets --}}
    <div class="row g-4">
        @forelse($projects as $project)
            <div class="col-lg-4 col-md-6">
                <div class="card project-card border-0 shadow-sm h-100">
                    {{-- Header avec badge statut --}}
                    <div class="card-header border-0 bg-white pb-0">
                        <div class="d-flex justify-content-between align-items-start">
                            @php
                                $badgeClass = match($project->statut) {
                                    'planifié' => 'secondary',
                                    'en_cours' => 'primary',
                                    'terminé' => 'success',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $badgeClass }} mb-2">
                                <i class="fas fa-{{ match($project->statut) {
                                    'planifié' => 'clock',
                                    'en_cours' => 'spinner',
                                    'terminé' => 'check-circle',
                                    default => 'question'
                                } }} me-1"></i>
                                {{ ucfirst(str_replace('_', ' ', $project->statut)) }}
                            </span>
                            <span class="badge bg-info">
                                {{ ucfirst($project->type) }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- Titre --}}
                        <h5 class="card-title mb-3">
                            <i class="fas fa-project-diagram text-primary me-2"></i>
                            {{ $project->titre }}
                        </h5>

                        {{-- Description --}}
                        <p class="card-text text-muted small mb-3">
                            {{ Str::limit($project->description, 100) }}
                        </p>

                        {{-- Infos --}}
                        <div class="project-info mb-3">
                            <div class="info-item">
                                <i class="fas fa-map-marker-alt text-danger"></i>
                                <span>{{ $project->zone->nom ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-building text-info"></i>
                                <span>{{ $project->infrastructure->nom ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-calendar text-success"></i>
                                <span>{{ \Carbon\Carbon::parse($project->date_debut)->format('d/m/Y') }}</span>
                            </div>
                        </div>

                        {{-- Budget --}}
                        <div class="budget-section mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small text-muted">
                                    <i class="fas fa-euro-sign me-1"></i> Budget
                                </span>
                                <strong class="text-primary">
                                    {{ number_format($project->budget_prevu, 0, ',', ' ') }} €
                                </strong>
                            </div>
                            @if($project->fundings->count() > 0)
                                @php
                                    $tauxFinancement = $project->budget_prevu > 0 ? ($project->fundingTotal() / $project->budget_prevu) * 100 : 0;
                                @endphp
                                <div class="small text-success mb-1">
                                    <i class="fas fa-check-circle me-1"></i>
                                    {{ number_format($tauxFinancement, 0) }}% financé
                                </div>
                            @endif
                        </div>

                        {{-- Avancement --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small text-muted">Avancement</span>
                                <strong>{{ $project->avancement_pourcentage }}%</strong>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" 
                                     role="progressbar" 
                                     style="width: {{ $project->avancement_pourcentage }}%">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer avec boutons --}}
                    <div class="card-footer bg-white border-0 pt-0">
                        <div class="d-grid gap-2">
                            <a href="{{ route('projects.show', $project) }}" 
                               class="btn btn-outline-primary">
                                <i class="fas fa-eye me-2"></i>
                                Voir les détails
                            </a>
                            @auth
                                @if(auth()->user()->role === \App\Enums\UserRole::Citoyen)
                                    <a href="{{ route('projects.donate', $project) }}" 
                                       class="btn btn-success btn-sm">
                                        <i class="fas fa-heart me-2"></i>
                                        Soutenir ce projet
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-search fa-4x text-muted mb-4"></i>
                    <h3 class="text-muted">Aucun projet trouvé</h3>
                    <p class="text-muted mb-4">Essayez de modifier vos critères de recherche</p>
                    <a href="{{ route('projects.index') }}" class="btn btn-primary">
                        <i class="fas fa-redo me-2"></i>
                        Réinitialiser les filtres
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($projects->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $projects->links('pagination::bootstrap-5') }}
        </div>
    @endif

    {{-- CTA Section --}}
    @guest
        <div class="card border-0 bg-gradient text-white mt-5 shadow-lg">
            <div class="card-body p-5 text-center">
                <i class="fas fa-hands-helping fa-4x mb-4 opacity-75"></i>
                <h2 class="mb-3">Rejoignez Notre Communauté</h2>
                <p class="lead mb-4">
                    Connectez-vous pour soutenir les projets et suivre leur évolution
                </p>
                <a href="{{ route('login') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Se connecter
                </a>
            </div>
        </div>
    @endguest
</div>
@endsection

@push('styles')
<style>
    .bg-gradient {
        background: linear-gradient(135deg, #1565c0 0%, #00b8d9 100%);
    }

    .hero-section .stat-box {
        background: rgba(255, 255, 255, 0.2);
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        backdrop-filter: blur(10px);
    }

    .hero-section .stat-box h3 {
        font-size: 2rem;
        font-weight: bold;
    }

    .project-card {
        transition: all 0.3s ease;
        border-radius: 1rem;
        overflow: hidden;
    }

    .project-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
    }

    .project-info .info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .project-info .info-item i {
        width: 20px;
    }

    .progress {
        border-radius: 1rem;
        overflow: hidden;
    }

    .progress-bar {
        transition: width 0.6s ease;
    }

    .badge {
        font-weight: 500;
        padding: 0.5rem 0.75rem;
    }
</style>
@endpush
