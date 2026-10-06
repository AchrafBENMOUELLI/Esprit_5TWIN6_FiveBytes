<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $project->titre }} - AquaSecure</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #0066cc;
            --primary-dark: #0052a3;
            --secondary: #00b8d9;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1e293b;
            --gray: #64748b;
            --light-gray: #f1f5f9;
            --white: #ffffff;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: white;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 2rem;
            padding: 0.75rem 1.5rem;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            transition: all 0.3s;
        }

        .back-button:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateX(-5px);
        }

        .project-hero {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            margin-bottom: 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .project-hero-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .project-title {
            flex: 1;
        }

        .project-title h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .project-badges {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-secondary {
            background: #e5e7eb;
            color: #374151;
        }

        .project-description {
            color: var(--gray);
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 1.5rem;
            border-radius: 16px;
            text-align: center;
        }

        .stat-card i {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--gray);
        }

        .section {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 3px solid var(--light-gray);
        }

        .section-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .section-title {
            flex: 1;
        }

        .section-title h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .section-title p {
            color: var(--gray);
            font-size: 0.95rem;
        }

        .budget-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .budget-card {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 1.5rem;
            border-radius: 16px;
            text-align: center;
        }

        .budget-card.success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        }

        .budget-card.warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        }

        .budget-label {
            font-size: 0.9rem;
            color: var(--gray);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .budget-amount {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
        }

        .progress-section {
            margin-bottom: 2rem;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .progress-bar {
            height: 30px;
            background: #e2e8f0;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--success) 0%, #34d399 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 1rem;
            color: white;
            font-weight: 700;
            transition: width 1s ease;
        }

        .phases-list {
            display: grid;
            gap: 1.5rem;
        }

        .phase-card {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 1.5rem;
            border-radius: 16px;
            border-left: 5px solid var(--primary);
        }

        .phase-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
        }

        .phase-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .phase-meta {
            display: flex;
            gap: 1.5rem;
            font-size: 0.9rem;
            color: var(--gray);
            margin-bottom: 1rem;
        }

        .timeline {
            position: relative;
            padding-left: 3rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 20px;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(180deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 2px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
        }

        .timeline-marker {
            position: absolute;
            left: -2.35rem;
            top: 5px;
            width: 24px;
            height: 24px;
            background: white;
            border: 4px solid var(--primary);
            border-radius: 50%;
            box-shadow: 0 0 0 6px rgba(0, 102, 204, 0.1);
        }

        .timeline-content {
            background: white;
            padding: 1.5rem;
            border-radius: 16px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .timeline-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }

        .timeline-title {
            font-weight: 700;
            color: var(--dark);
            font-size: 1.1rem;
        }

        .timeline-date {
            color: var(--gray);
            font-size: 0.9rem;
        }

        .documents-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .document-card {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 1.5rem;
            border-radius: 16px;
            text-align: center;
            transition: all 0.3s;
        }

        .document-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .document-icon {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .document-name {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 102, 204, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success) 0%, #34d399 100%);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        }

        .support-card {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 2.5rem;
            border-radius: 20px;
            text-align: center;
            margin-bottom: 2rem;
        }

        .support-card h3 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .support-card p {
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .project-hero {
                padding: 2rem;
            }

            .project-hero-header {
                flex-direction: column;
            }

            .project-title h1 {
                font-size: 1.75rem;
            }

            .section {
                padding: 1.5rem;
            }

            .timeline {
                padding-left: 2rem;
            }
        }
    </style>
</head>
<body>
    {{-- Navbar --}}
    <x-shared.navbar />

    <div class="container">
        <a href="{{ route('projects.index') }}" class="back-button">
            <i class="fas fa-arrow-left"></i> Retour aux projets
        </a>

        {{-- Project Hero --}}
        <div class="project-hero">
            <div class="project-hero-header">
                <div class="project-title">
                    <h1>{{ $project->titre }}</h1>
                    <div class="project-badges">
                        @php
                            $statusClass = match($project->statut) {
                                'en_cours' => 'success',
                                'planifié' => 'info',
                                'terminé' => 'secondary',
                                'suspendu' => 'warning',
                                default => 'secondary'
                            };
                        @endphp
                        <span class="badge badge-{{ $statusClass }}">
                            <i class="fas fa-circle"></i>
                            {{ ucfirst(str_replace('_', ' ', $project->statut)) }}
                        </span>
                        <span class="badge badge-info">
                            <i class="fas fa-tag"></i>
                            {{ ucfirst($project->type) }}
                        </span>
                        <span class="badge badge-secondary">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $project->zone ? $project->zone->nom : 'N/A' }}
                        </span>
                    </div>
                    @if($project->description)
                        <p class="project-description">{{ $project->description }}</p>
                    @endif
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <i class="fas fa-calendar"></i>
                    <div class="stat-value">{{ \Carbon\Carbon::parse($project->date_debut)->format('d/m/Y') }}</div>
                    <div class="stat-label">Date de début</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-coins"></i>
                    <div class="stat-value">{{ number_format($project->budget_prevu, 0, ',', ' ') }}</div>
                    <div class="stat-label">Budget prévu (TND)</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-building"></i>
                    <div class="stat-value">{{ $project->infrastructure ? $project->infrastructure->nom : 'N/A' }}</div>
                    <div class="stat-label">Infrastructure</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-tasks"></i>
                    <div class="stat-value">{{ $project->projectPhases->count() }}</div>
                    <div class="stat-label">Phases</div>
                </div>
            </div>
        </div>

        {{-- Support Card --}}
        @auth
            @if(auth()->user()->role === \App\Enums\UserRole::Citoyen)
            <div class="support-card">
                <i class="fas fa-hand-holding-heart" style="font-size: 4rem; margin-bottom: 1rem;"></i>
                <h3>Soutenir ce Projet</h3>
                <p>Votre contribution aide à améliorer les infrastructures hydrauliques de votre région</p>
                <a href="{{ route('projects.donate', $project) }}" class="btn btn-success" style="font-size: 1.1rem; padding: 1rem 2rem;">
                    <i class="fas fa-heart"></i> Faire un Don Simulé
                </a>
            </div>
            @endif
        @endauth

        {{-- Budget Section --}}
        <div class="section">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div class="section-title">
                    <h2>Transparence Budgétaire</h2>
                    <p>Suivi détaillé du budget et des financements</p>
                </div>
            </div>

            <div class="budget-overview">
                <div class="budget-card">
                    <div class="budget-label">Budget Prévu</div>
                    <div class="budget-amount">{{ number_format($project->budget_prevu, 0, ',', ' ') }}</div>
                    <div style="font-size: 0.9rem; color: var(--gray); margin-top: 0.25rem;">TND</div>
                </div>
                <div class="budget-card success">
                    <div class="budget-label">Financements Reçus</div>
                    <div class="budget-amount">{{ number_format($project->fundingTotal(), 0, ',', ' ') }}</div>
                    <div style="font-size: 0.9rem; color: var(--gray); margin-top: 0.25rem;">TND</div>
                </div>
                <div class="budget-card warning">
                    <div class="budget-label">Restant à Financer</div>
                    <div class="budget-amount">{{ number_format($project->budgetRemaining(), 0, ',', ' ') }}</div>
                    <div style="font-size: 0.9rem; color: var(--gray); margin-top: 0.25rem;">TND</div>
                </div>
            </div>

            <div class="progress-section">
                <div class="progress-header">
                    <span>Progression du Financement</span>
                    <span>{{ $project->budget_prevu > 0 ? round(($project->fundingTotal() / $project->budget_prevu) * 100) : 0 }}%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $project->budget_prevu > 0 ? min(($project->fundingTotal() / $project->budget_prevu) * 100, 100) : 0 }}%">
                        {{ number_format($project->fundingTotal(), 0, ',', ' ') }} TND
                    </div>
                </div>
            </div>
        </div>

        {{-- Phases Section --}}
        @if($project->projectPhases->count() > 0)
        <div class="section">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="section-title">
                    <h2>Phases du Projet</h2>
                    <p>Détail de l'avancement des travaux</p>
                </div>
            </div>

            <div class="phases-list">
                @foreach($project->projectPhases->sortBy('ordre') as $phase)
                    <div class="phase-card">
                        <div class="phase-header">
                            <div>
                                <div class="phase-title">
                                    <span style="background: var(--primary); color: white; padding: 0.25rem 0.75rem; border-radius: 8px; margin-right: 0.5rem; font-size: 0.9rem;">{{ $phase->ordre }}</span>
                                    {{ $phase->nom }}
                                </div>
                                <div class="phase-meta">
                                    <span><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($phase->date_debut)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($phase->date_fin)->format('d/m/Y') }}</span>
                                    @if($phase->contractor)
                                        <span><i class="fas fa-user-tie"></i> {{ $phase->contractor->nom }}</span>
                                    @endif
                                    <span><i class="fas fa-coins"></i> {{ number_format($phase->cout, 0, ',', ' ') }} TND</span>
                                </div>
                            </div>
                            <span class="badge badge-{{ $phase->statut === 'terminé' ? 'success' : ($phase->statut === 'en_cours' ? 'info' : 'secondary') }}">
                                {{ ucfirst(str_replace('_', ' ', $phase->statut)) }}
                            </span>
                        </div>

                        <div class="progress-section">
                            <div class="progress-header">
                                <span>Avancement</span>
                                <span>{{ $phase->avancement }}%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $phase->avancement }}%">
                                    {{ $phase->avancement }}%
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Timeline --}}
        <div class="section">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-history"></i>
                </div>
                <div class="section-title">
                    <h2>Chronologie du Projet</h2>
                    <p>Historique et événements clés</p>
                </div>
            </div>

            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <div class="timeline-header">
                            <div class="timeline-title">Démarrage du Projet</div>
                            <div class="timeline-date">{{ \Carbon\Carbon::parse($project->date_debut)->format('d/m/Y') }}</div>
                        </div>
                        <p style="color: var(--gray);">Le projet a été lancé officiellement</p>
                    </div>
                </div>

                @foreach($project->fundings->sortBy('date_versement') as $funding)
                <div class="timeline-item">
                    <div class="timeline-marker" style="border-color: var(--success);"></div>
                    <div class="timeline-content">
                        <div class="timeline-header">
                            <div class="timeline-title">Financement Reçu</div>
                            <div class="timeline-date">{{ \Carbon\Carbon::parse($funding->date_versement)->format('d/m/Y') }}</div>
                        </div>
                        <p style="color: var(--gray);">{{ ucfirst($funding->source) }} - {{ number_format($funding->montant, 0, ',', ' ') }} TND</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Documents --}}
        @if($project->projectDocuments->where('type', 'public')->count() > 0)
        <div class="section">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-folder-open"></i>
                </div>
                <div class="section-title">
                    <h2>Documents Publics</h2>
                    <p>Téléchargez les documents du projet</p>
                </div>
            </div>

            <div class="documents-grid">
                @foreach($project->projectDocuments->where('type', 'public') as $document)
                    <div class="document-card">
                        <div class="document-icon">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="document-name">{{ $document->nom }}</div>
                        <a href="{{ Storage::url($document->fichier) }}" class="btn btn-primary" style="width: 100%; justify-content: center;" download>
                            <i class="fas fa-download"></i> Télécharger
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <script>
        // Animate progress bars on load
        window.addEventListener('load', () => {
            document.querySelectorAll('.progress-fill').forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
            });
        });
    </script>
</body>
</html>
