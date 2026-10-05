<x-project.layouts.front>
    <div class="container py-5">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('projects.index') }}" class="text-decoration-none">Projets</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $project->titre }}</li>
            </ol>
        </nav>

        {{-- Project Header --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <div class="bg-primary bg-opacity-10 rounded p-3">
                                <i class="fas fa-{{ $project->type === 'rénovation' ? 'tools' : ($project->type === 'extension' ? 'expand-arrows-alt' : 'water') }} fa-2x text-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h1 class="h3 mb-2">{{ $project->titre }}</h1>
                                <div class="d-flex flex-wrap gap-2 mb-2">
                                    <span class="badge bg-{{ $project->statut === 'en_cours' ? 'success' : ($project->statut === 'planifié' ? 'info' : ($project->statut === 'terminé' ? 'secondary' : 'warning')) }}">
                                        <i class="fas fa-circle me-1"></i>
                                        {{ ucfirst(str_replace('_', ' ', $project->statut)) }}
                                    </span>
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-tag me-1"></i>
                                        {{ ucfirst($project->type) }}
                                    </span>
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-layer-group me-1"></i>
                                        Priorité: {{ ucfirst($project->priorite) }}
                                    </span>
                                </div>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $project->infrastructure->nom }} - {{ $project->zone->nom }}
                                </p>
                            </div>
                        </div>
                        
                        @if($project->description)
                        <div class="mt-3">
                            <h6 class="fw-bold mb-2">Description</h6>
                            <p class="text-muted mb-0">{{ $project->description }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="col-lg-4">
                        <div class="card bg-light border-0">
                            <div class="card-body text-center">
                                <div class="mb-2">
                                    <i class="fas fa-calendar-alt text-primary fa-2x mb-2"></i>
                                </div>
                                <div class="small text-muted mb-1">Période</div>
                                <div class="fw-bold">
                                    {{ \Carbon\Carbon::parse($project->date_debut)->format('d/m/Y') }}
                                </div>
                                <div class="text-muted mb-2">
                                    <i class="fas fa-arrow-down"></i>
                                </div>
                                <div class="fw-bold">
                                    {{ $project->date_fin ? \Carbon\Carbon::parse($project->date_fin)->format('d/m/Y') : 'Non définie' }}
                                </div>
                                @if($project->date_debut && $project->date_fin)
                                <div class="small text-muted mt-2">
                                    Durée: {{ \Carbon\Carbon::parse($project->date_debut)->diffInDays($project->date_fin) }} jours
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- Main Content --}}
            <div class="col-lg-8">
                {{-- Transparency Section - Budget --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-success bg-opacity-10 rounded p-2 me-3">
                                <i class="fas fa-chart-pie text-success fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Transparence Financière</h5>
                                <p class="text-muted mb-0 small">Suivi du budget et des financements</p>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="text-center p-3 bg-light rounded">
                                    <div class="small text-muted mb-1">Budget Prévu</div>
                                    <div class="h4 mb-0 text-primary">{{ number_format($project->budget_prevu, 0, ',', ' ') }} TND</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center p-3 bg-light rounded">
                                    <div class="small text-muted mb-1">Financements Reçus</div>
                                    <div class="h4 mb-0 text-success">{{ number_format($project->fundingTotal(), 0, ',', ' ') }} TND</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center p-3 bg-light rounded">
                                    <div class="small text-muted mb-1">Restant</div>
                                    <div class="h4 mb-0 text-{{ $project->budgetRemaining() > 0 ? 'warning' : 'success' }}">
                                        {{ number_format($project->budgetRemaining(), 0, ',', ' ') }} TND
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Budget Progress Bar --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small fw-bold">Progression du financement</span>
                                <span class="small fw-bold">{{ $project->budget_prevu > 0 ? round(($project->fundingTotal() / $project->budget_prevu) * 100) : 0 }}%</span>
                            </div>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                     style="width: {{ $project->budget_prevu > 0 ? min(($project->fundingTotal() / $project->budget_prevu) * 100, 100) : 0 }}%"
                                     aria-valuenow="{{ $project->budget_prevu > 0 ? ($project->fundingTotal() / $project->budget_prevu) * 100 : 0 }}" 
                                     aria-valuemin="0" aria-valuemax="100">
                                    <span class="fw-bold">{{ number_format($project->fundingTotal(), 0, ',', ' ') }} TND</span>
                                </div>
                            </div>
                        </div>

                        {{-- Funding Sources --}}
                        @if($project->fundings->count() > 0)
                        <div class="mt-4">
                            <h6 class="fw-bold mb-3">Sources de Financement</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Source</th>
                                            <th>Montant</th>
                                            <th>Date</th>
                                            <th>Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($project->fundings as $funding)
                                        <tr>
                                            <td>
                                                <i class="fas fa-{{ $funding->source === 'don' ? 'hand-holding-heart' : ($funding->source === 'subvention' ? 'landmark' : 'building') }} me-2 text-muted"></i>
                                                {{ ucfirst($funding->source) }}
                                                @if($funding->source === 'don' && $funding->donateur)
                                                    <small class="text-muted">({{ $funding->donateur->name }})</small>
                                                @endif
                                            </td>
                                            <td class="fw-bold">{{ number_format($funding->montant, 0, ',', ' ') }} TND</td>
                                            <td>{{ \Carbon\Carbon::parse($funding->date_reception)->format('d/m/Y') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $funding->statut === 'approuvé' ? 'success' : ($funding->statut === 'en_attente' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($funding->statut) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Project Phases --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-info bg-opacity-10 rounded p-2 me-3">
                                <i class="fas fa-tasks text-info fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Phases du Projet</h5>
                                <p class="text-muted mb-0 small">Avancement des différentes étapes</p>
                            </div>
                        </div>

                        @forelse($project->projectPhases->sortBy('ordre') as $phase)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <h6 class="mb-1">
                                        <span class="badge bg-light text-dark me-2">{{ $phase->ordre }}</span>
                                        {{ $phase->nom }}
                                    </h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($phase->date_debut)->format('d/m/Y') }} - 
                                        {{ \Carbon\Carbon::parse($phase->date_fin)->format('d/m/Y') }}
                                        @if($phase->contractor)
                                        <span class="ms-2">
                                            <i class="fas fa-user-tie me-1"></i>
                                            {{ $phase->contractor->nom }}
                                        </span>
                                        @endif
                                    </small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-{{ $phase->statut === 'terminé' ? 'success' : ($phase->statut === 'en_cours' ? 'primary' : 'secondary') }} mb-1">
                                        {{ ucfirst(str_replace('_', ' ', $phase->statut)) }}
                                    </span>
                                    <div class="small text-muted">{{ number_format($phase->cout, 0, ',', ' ') }} TND</div>
                                </div>
                            </div>
                            
                            @if($phase->description)
                            <p class="text-muted small mb-2">{{ $phase->description }}</p>
                            @endif

                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-{{ $phase->avancement >= 100 ? 'success' : ($phase->avancement >= 50 ? 'info' : 'warning') }}" 
                                     role="progressbar" 
                                     style="width: {{ $phase->avancement }}%"
                                     aria-valuenow="{{ $phase->avancement }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    <span class="fw-bold">{{ $phase->avancement }}%</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                            <p class="mb-0">Aucune phase définie pour ce projet</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                {{-- Timeline --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-warning bg-opacity-10 rounded p-2 me-3">
                                <i class="fas fa-history text-warning fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Chronologie du Projet</h5>
                                <p class="text-muted mb-0 small">Historique et événements clés</p>
                            </div>
                        </div>

                        <div class="timeline">
                            {{-- Project Start --}}
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1">Démarrage du Projet</h6>
                                            <p class="text-muted small mb-0">Le projet a été lancé officiellement</p>
                                        </div>
                                        <span class="badge bg-light text-dark">{{ \Carbon\Carbon::parse($project->date_debut)->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Phases Timeline --}}
                            @foreach($project->projectPhases->sortBy('date_debut') as $phase)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-{{ $phase->statut === 'terminé' ? 'success' : ($phase->statut === 'en_cours' ? 'info' : 'secondary') }}"></div>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1">Phase: {{ $phase->nom }}</h6>
                                            <p class="text-muted small mb-0">
                                                Avancement: {{ $phase->avancement }}%
                                                @if($phase->contractor)
                                                - Prestataire: {{ $phase->contractor->nom }}
                                                @endif
                                            </p>
                                        </div>
                                        <span class="badge bg-{{ $phase->statut === 'terminé' ? 'success' : ($phase->statut === 'en_cours' ? 'primary' : 'secondary') }}">
                                            {{ ucfirst(str_replace('_', ' ', $phase->statut)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            {{-- Fundings Timeline --}}
                            @foreach($project->fundings->where('statut', 'approuvé')->sortBy('date_reception') as $funding)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1">Financement Reçu</h6>
                                            <p class="text-muted small mb-0">
                                                {{ ucfirst($funding->source) }} - {{ number_format($funding->montant, 0, ',', ' ') }} TND
                                            </p>
                                        </div>
                                        <span class="badge bg-light text-dark">{{ \Carbon\Carbon::parse($funding->date_reception)->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            {{-- Project End (if date exists) --}}
                            @if($project->date_fin)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-{{ $project->statut === 'terminé' ? 'success' : 'secondary' }}"></div>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1">{{ $project->statut === 'terminé' ? 'Fin du Projet' : 'Fin Prévue' }}</h6>
                                            <p class="text-muted small mb-0">Date de clôture {{ $project->statut === 'terminé' ? 'effective' : 'estimée' }}</p>
                                        </div>
                                        <span class="badge bg-light text-dark">{{ \Carbon\Carbon::parse($project->date_fin)->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Public Documents --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-secondary bg-opacity-10 rounded p-2 me-3">
                                <i class="fas fa-folder-open text-secondary fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Documents Publics</h5>
                                <p class="text-muted mb-0 small">Téléchargez les documents du projet</p>
                            </div>
                        </div>

                        @php
                            $publicDocs = $project->projectDocuments->where('type', 'public');
                        @endphp

                        @if($publicDocs->count() > 0)
                        <div class="row g-3">
                            @foreach($publicDocs as $document)
                            <div class="col-md-6">
                                <div class="card border h-100 hover-shadow">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-start gap-3">
                                            <div class="bg-light rounded p-2">
                                                <i class="fas fa-{{ str_ends_with(strtolower($document->fichier), '.pdf') ? 'file-pdf text-danger' : (str_ends_with(strtolower($document->fichier), ['.doc', '.docx']) ? 'file-word text-primary' : (str_ends_with(strtolower($document->fichier), ['.jpg', '.png']) ? 'file-image text-info' : 'file text-secondary')) }} fa-2x"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $document->nom }}</h6>
                                                @if($document->description)
                                                <p class="text-muted small mb-2">{{ Str::limit($document->description, 60) }}</p>
                                                @endif
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar me-1"></i>
                                                        {{ \Carbon\Carbon::parse($document->created_at)->format('d/m/Y') }}
                                                    </small>
                                                    <a href="{{ Storage::url($document->fichier) }}" 
                                                       class="btn btn-sm btn-outline-primary" 
                                                       download>
                                                        <i class="fas fa-download me-1"></i>
                                                        Télécharger
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                            <p class="mb-0">Aucun document public disponible</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Support Section --}}
                <div class="card border-0 shadow-sm mb-4 bg-gradient" style="background: linear-gradient(135deg, #0b2545 0%, #1565c0 100%);">
                    <div class="card-body p-4 text-white">
                        <div class="text-center mb-3">
                            <i class="fas fa-hand-holding-heart fa-3x mb-3 opacity-75"></i>
                            <h5 class="mb-2">Soutenir ce Projet</h5>
                            <p class="mb-4 small opacity-75">Votre contribution aide à améliorer les infrastructures hydrauliques de votre région</p>
                        </div>

                        @auth
                            @if(auth()->user()->role === \App\Enums\UserRole::Citoyen)
                            <a href="{{ route('projects.donate', $project) }}" class="btn btn-light btn-lg w-100 mb-3">
                                <i class="fas fa-heart me-2"></i>
                                Faire un Don Simulé
                            </a>
                            @else
                            <div class="alert alert-light mb-0 small">
                                <i class="fas fa-info-circle me-2"></i>
                                Les dons sont réservés aux citoyens
                            </div>
                            @endif
                        @else
                        <a href="{{ route('login') }}" class="btn btn-light btn-lg w-100 mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Connectez-vous pour Donner
                        </a>
                        @endauth

                        <div class="row g-2 text-center mt-3">
                            <div class="col-6">
                                <div class="bg-white bg-opacity-10 rounded p-2">
                                    <div class="small opacity-75">Objectif Restant</div>
                                    <div class="fw-bold">{{ number_format($project->budgetRemaining(), 0, ',', ' ') }}</div>
                                    <div class="x-small opacity-75">TND</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-white bg-opacity-10 rounded p-2">
                                    <div class="small opacity-75">Contributeurs</div>
                                    <div class="fw-bold">{{ $project->fundings->where('source', 'don')->count() }}</div>
                                    <div class="x-small opacity-75">Dons</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Project Stats --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">Statistiques du Projet</h6>
                        
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small">
                                    <i class="fas fa-tasks me-2"></i>Phases
                                </span>
                                <span class="fw-bold">{{ $project->projectPhases->count() }}</span>
                            </div>
                            <div class="small text-muted">
                                {{ $project->projectPhases->where('statut', 'terminé')->count() }} terminées, 
                                {{ $project->projectPhases->where('statut', 'en_cours')->count() }} en cours
                            </div>
                        </div>

                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small">
                                    <i class="fas fa-percentage me-2"></i>Avancement Global
                                </span>
                                <span class="fw-bold">
                                    {{ $project->projectPhases->count() > 0 ? round($project->projectPhases->avg('avancement')) : 0 }}%
                                </span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar" 
                                     style="width: {{ $project->projectPhases->count() > 0 ? $project->projectPhases->avg('avancement') : 0 }}%"></div>
                            </div>
                        </div>

                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small">
                                    <i class="fas fa-coins me-2"></i>Sources de Financement
                                </span>
                                <span class="fw-bold">{{ $project->fundings->count() }}</span>
                            </div>
                            <div class="small text-muted">
                                {{ $project->fundings->where('statut', 'approuvé')->count() }} approuvés
                            </div>
                        </div>

                        <div class="mb-0">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small">
                                    <i class="fas fa-file-alt me-2"></i>Documents
                                </span>
                                <span class="fw-bold">{{ $publicDocs->count() }}</span>
                            </div>
                            <div class="small text-muted">Documents publics disponibles</div>
                        </div>
                    </div>
                </div>

                {{-- Contact Info --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">Informations</h6>
                        
                        <div class="mb-3">
                            <div class="text-muted small mb-1">Infrastructure</div>
                            <div class="fw-bold">{{ $project->infrastructure->nom }}</div>
                            <div class="text-muted small">{{ $project->infrastructure->type }}</div>
                        </div>

                        <div class="mb-3">
                            <div class="text-muted small mb-1">Zone</div>
                            <div class="fw-bold">{{ $project->zone->nom }}</div>
                        </div>

                        @if($project->projectPhases->count() > 0)
                        <div class="mb-3">
                            <div class="text-muted small mb-1">Prestataires Impliqués</div>
                            @php
                                $contractors = $project->projectPhases->pluck('contractor')->filter()->unique('id');
                            @endphp
                            @foreach($contractors as $contractor)
                            <div class="small mb-1">
                                <i class="fas fa-user-tie me-2 text-muted"></i>
                                {{ $contractor->nom }}
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <div class="mb-0">
                            <div class="text-muted small mb-1">Dernière mise à jour</div>
                            <div class="small">{{ $project->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Back Button --}}
        <div class="text-center mt-4">
            <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Retour à la Liste des Projets
            </a>
        </div>
    </div>

    <style>
        .hover-shadow {
            transition: box-shadow 0.3s ease;
        }
        .hover-shadow:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        /* Timeline Styles */
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(180deg, #0b2545 0%, #1565c0 50%, #00b8d9 100%);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-marker {
            position: absolute;
            left: -26px;
            top: 5px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 0 0 2px #e9ecef;
        }

        .timeline-content {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-left: 10px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .timeline {
                padding-left: 20px;
            }
            .timeline-marker {
                left: -16px;
                width: 14px;
                height: 14px;
            }
        }
    </style>
</x-project.layouts.front>
