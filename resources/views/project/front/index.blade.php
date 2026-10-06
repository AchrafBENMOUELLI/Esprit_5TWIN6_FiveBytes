<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projets de Rénovation - AquaSecure</title>
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

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
        }

        .navbar-nav {
            display: flex;
            gap: 2rem;
            list-style: none;
            align-items: center;
        }

        .navbar-nav a {
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .navbar-nav a:hover {
            color: var(--primary);
        }

        .hero {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.9) 0%, rgba(118, 75, 162, 0.9) 100%);
            padding: 4rem 2rem;
            text-align: center;
            color: white;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .hero p {
            font-size: 1.25rem;
            opacity: 0.95;
            max-width: 600px;
            margin: 0 auto 2rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .filters {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin: -3rem auto 3rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            position: relative;
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark);
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(0, 102, 204, 0.1);
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

        .btn-secondary {
            background: #e2e8f0;
            color: var(--dark);
        }

        .btn-secondary:hover {
            background: #cbd5e1;
        }

        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
        }

        .project-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            position: relative;
        }

        .project-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }

        .project-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
        }

        .project-header {
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .project-header h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.75rem;
        }

        .project-badges {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .badge {
            padding: 0.4rem 0.9rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
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

        .project-body {
            padding: 1.5rem;
        }

        .project-description {
            color: var(--gray);
            margin-bottom: 1.5rem;
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .project-meta {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .meta-item i {
            color: var(--primary);
            width: 20px;
        }

        .progress-section {
            margin-bottom: 1.5rem;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .progress-bar {
            height: 10px;
            background: #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--success) 0%, #34d399 100%);
            border-radius: 10px;
            transition: width 0.5s ease;
        }

        .project-footer {
            padding: 0 1.5rem 1.5rem;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 20px;
            margin: 3rem 0;
        }

        .empty-state i {
            font-size: 4rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .empty-state p {
            color: var(--gray);
            margin-bottom: 1.5rem;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin: 3rem 0;
            flex-wrap: wrap;
        }

        .pagination a,
        .pagination span {
            padding: 0.75rem 1.25rem;
            border-radius: 12px;
            text-decoration: none;
            color: var(--dark);
            background: white;
            font-weight: 600;
            transition: all 0.3s;
        }

        .pagination a:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        .pagination .active {
            background: var(--primary);
            color: white;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .filters-grid {
                grid-template-columns: 1fr;
            }

            .projects-grid {
                grid-template-columns: 1fr;
            }

            .navbar-nav {
                gap: 1rem;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    {{-- Navbar --}}
    <x-shared.navbar />

    {{-- Hero Section --}}
    <section class="hero">
        <h1><i class="fas fa-tools"></i> Projets de Rénovation</h1>
        <p>Découvrez nos projets d'amélioration des infrastructures hydrauliques pour un avenir durable</p>
    </section>

    <div class="container">
        {{-- Filters --}}
        <div class="filters">
            <form method="GET" action="{{ route('projects.index') }}">
                <div class="filters-grid">
                    <div class="form-group">
                        <label><i class="fas fa-search"></i> Recherche</label>
                        <input type="text" name="search" class="form-control" placeholder="Nom du projet..." value="{{ request('search') }}">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-map-marker-alt"></i> Zone</label>
                        <select name="zone_id" class="form-control">
                            <option value="">Toutes les zones</option>
                            @foreach($zones as $zone)
                                <option value="{{ $zone->id }}" {{ request('zone_id') == $zone->id ? 'selected' : '' }}>
                                    {{ $zone->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-tag"></i> Type</label>
                        <select name="type" class="form-control">
                            <option value="">Tous les types</option>
                            <option value="rénovation" {{ request('type') == 'rénovation' ? 'selected' : '' }}>Rénovation</option>
                            <option value="extension" {{ request('type') == 'extension' ? 'selected' : '' }}>Extension</option>
                            <option value="nouveau" {{ request('type') == 'nouveau' ? 'selected' : '' }}>Nouveau</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-chart-line"></i> Statut</label>
                        <select name="statut" class="form-control">
                            <option value="">Tous les statuts</option>
                            <option value="planifié" {{ request('statut') == 'planifié' ? 'selected' : '' }}>Planifié</option>
                            <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                            <option value="terminé" {{ request('statut') == 'terminé' ? 'selected' : '' }}>Terminé</option>
                        </select>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filtrer
                    </button>
                    @if(request()->hasAny(['search', 'zone_id', 'type', 'statut']))
                        <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Réinitialiser
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Projects Grid --}}
        @if($projects->count() > 0)
            <div class="projects-grid">
                @foreach($projects as $project)
                    <div class="project-card">
                        <div class="project-header">
                            <h3>{{ $project->titre }}</h3>
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
                            </div>
                        </div>

                        <div class="project-body">
                            <p class="project-description">{{ $project->description }}</p>

                            <div class="project-meta">
                                <div class="meta-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $project->zone ? $project->zone->nom : 'N/A' }}</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-calendar"></i>
                                    <span>{{ \Carbon\Carbon::parse($project->date_debut)->format('d/m/Y') }}</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-coins"></i>
                                    <span>{{ number_format($project->budget_prevu, 0, ',', ' ') }} TND</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-building"></i>
                                    <span>{{ $project->infrastructure ? $project->infrastructure->nom : 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="progress-section">
                                <div class="progress-header">
                                    <span>Financement</span>
                                    <span>{{ $project->budget_prevu > 0 ? round(($project->fundingTotal() / $project->budget_prevu) * 100) : 0 }}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $project->budget_prevu > 0 ? min(($project->fundingTotal() / $project->budget_prevu) * 100, 100) : 0 }}%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="project-footer">
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-primary" style="width: 100%; justify-content: center;">
                                <i class="fas fa-eye"></i> Voir les détails
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="pagination">
                {{ $projects->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>Aucun projet trouvé</h3>
                <p>Essayez de modifier vos critères de recherche</p>
                <a href="{{ route('projects.index') }}" class="btn btn-primary">
                    <i class="fas fa-redo"></i> Réinitialiser les filtres
                </a>
            </div>
        @endif
    </div>

    <script>
        // Add smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.project-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s, transform 0.5s';
            observer.observe(card);
        });
    </script>
</body>
</html>
