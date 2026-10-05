<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Module CSS - Demo</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        {!! file_get_contents(resource_path('views/base.css')) !!}
        {!! file_get_contents(resource_path('views/components/project/project.css')) !!}
        
        /* Demo Page Styles */
        .demo-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .demo-section {
            margin-bottom: 4rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid var(--border);
        }
        
        .demo-section:last-child {
            border-bottom: none;
        }
        
        .demo-header {
            margin-bottom: 2rem;
        }
        
        .demo-title {
            font-size: 2rem;
            color: var(--navy);
            margin-bottom: 0.5rem;
        }
        
        .demo-subtitle {
            color: var(--muted);
            font-size: 1.1rem;
        }
        
        .demo-grid {
            display: grid;
            gap: 1.5rem;
        }
        
        .demo-grid-2 {
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }
        
        .demo-grid-3 {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }
        
        .demo-block {
            background: var(--white);
            padding: 1.5rem;
            border-radius: 8px;
            border: 1px solid var(--border);
        }
        
        .demo-block-title {
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }
        
        .color-swatch {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.75rem;
        }
        
        .color-box {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            border: 2px solid var(--border);
        }
        
        .color-info {
            flex: 1;
        }
        
        .color-name {
            font-weight: 600;
            color: var(--text);
        }
        
        .color-value {
            font-size: 0.85rem;
            color: var(--muted);
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="demo-container">
        <!-- Header -->
        <div class="demo-header">
            <h1 class="demo-title">
                <i class="fas fa-palette"></i>
                Project Module CSS Demo
            </h1>
            <p class="demo-subtitle">
                Documentation interactive et exemples visuels de toutes les classes CSS du module
            </p>
        </div>
        
        <!-- 1. Color Palette -->
        <section class="demo-section">
            <h2 class="demo-title">🎨 Palette de Couleurs</h2>
            
            <div class="demo-grid demo-grid-2">
                <div class="demo-block">
                    <h3 class="demo-block-title">Couleurs Principales</h3>
                    
                    <div class="color-swatch">
                        <div class="color-box" style="background: var(--navy);"></div>
                        <div class="color-info">
                            <div class="color-name">Navy</div>
                            <div class="color-value">--navy: #0b2545</div>
                        </div>
                    </div>
                    
                    <div class="color-swatch">
                        <div class="color-box" style="background: var(--ocean);"></div>
                        <div class="color-info">
                            <div class="color-name">Ocean</div>
                            <div class="color-value">--ocean: #1565c0</div>
                        </div>
                    </div>
                    
                    <div class="color-swatch">
                        <div class="color-box" style="background: var(--aqua);"></div>
                        <div class="color-info">
                            <div class="color-name">Aqua</div>
                            <div class="color-value">--aqua: #00b8d9</div>
                        </div>
                    </div>
                </div>
                
                <div class="demo-block">
                    <h3 class="demo-block-title">Couleurs de Statut</h3>
                    
                    <div class="color-swatch">
                        <div class="color-box" style="background: var(--success);"></div>
                        <div class="color-info">
                            <div class="color-name">Success</div>
                            <div class="color-value">--success: #2e9e5b</div>
                        </div>
                    </div>
                    
                    <div class="color-swatch">
                        <div class="color-box" style="background: var(--warning);"></div>
                        <div class="color-info">
                            <div class="color-name">Warning</div>
                            <div class="color-value">--warning: #f59e0b</div>
                        </div>
                    </div>
                    
                    <div class="color-swatch">
                        <div class="color-box" style="background: var(--danger);"></div>
                        <div class="color-info">
                            <div class="color-name">Danger</div>
                            <div class="color-value">--danger: #d93b3b</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- 2. Status Badges -->
        <section class="demo-section">
            <h2 class="demo-title">🏷️ Badges de Statut</h2>
            
            <div class="demo-grid demo-grid-3">
                <div class="demo-block">
                    <h3 class="demo-block-title">Statuts de Projet</h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                        <span class="badge-status planifie">
                            <i class="fas fa-circle"></i>
                            Planifié
                        </span>
                        <span class="badge-status en-cours">
                            <i class="fas fa-circle"></i>
                            En Cours
                        </span>
                        <span class="badge-status termine">
                            <i class="fas fa-circle"></i>
                            Terminé
                        </span>
                        <span class="badge-status suspendu">
                            <i class="fas fa-circle"></i>
                            Suspendu
                        </span>
                        <span class="badge-status annule">
                            <i class="fas fa-circle"></i>
                            Annulé
                        </span>
                    </div>
                </div>
                
                <div class="demo-block">
                    <h3 class="demo-block-title">Types de Projet</h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                        <span class="badge-type">
                            <i class="fas fa-tools"></i>
                            Rénovation
                        </span>
                        <span class="badge-type">
                            <i class="fas fa-expand-arrows-alt"></i>
                            Extension
                        </span>
                        <span class="badge-type">
                            <i class="fas fa-plus-circle"></i>
                            Nouveau
                        </span>
                    </div>
                </div>
                
                <div class="demo-block">
                    <h3 class="demo-block-title">Priorités</h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                        <span class="badge-priority haute">Haute</span>
                        <span class="badge-priority moyenne">Moyenne</span>
                        <span class="badge-priority basse">Basse</span>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- 3. Progress Bars -->
        <section class="demo-section">
            <h2 class="demo-title">📊 Barres de Progression</h2>
            
            <div class="demo-grid demo-grid-2">
                <div class="demo-block">
                    <h3 class="demo-block-title">Tailles & Variantes</h3>
                    
                    <div class="progress-wrapper">
                        <div class="progress-header">
                            <span class="progress-label">Petite (12px)</span>
                            <span class="progress-percentage">45%</span>
                        </div>
                        <div class="progress-bar-custom small">
                            <div class="progress-bar-fill" style="width: 45%">
                                <span class="progress-bar-text">45%</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="progress-wrapper">
                        <div class="progress-header">
                            <span class="progress-label">Normale (20px)</span>
                            <span class="progress-percentage">75%</span>
                        </div>
                        <div class="progress-bar-custom">
                            <div class="progress-bar-fill" style="width: 75%">
                                <span class="progress-bar-text">75%</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="progress-wrapper">
                        <div class="progress-header">
                            <span class="progress-label">Grande (32px)</span>
                            <span class="progress-percentage">90%</span>
                        </div>
                        <div class="progress-bar-custom large">
                            <div class="progress-bar-fill success" style="width: 90%">
                                <span class="progress-bar-text">90%</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="demo-block">
                    <h3 class="demo-block-title">Couleurs</h3>
                    
                    <div class="progress-wrapper">
                        <div class="progress-header">
                            <span class="progress-label">Défaut (Bleu)</span>
                            <span class="progress-percentage">60%</span>
                        </div>
                        <div class="progress-bar-custom">
                            <div class="progress-bar-fill" style="width: 60%">
                                <span class="progress-bar-text">60%</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="progress-wrapper">
                        <div class="progress-header">
                            <span class="progress-label">Success (Vert)</span>
                            <span class="progress-percentage">85%</span>
                        </div>
                        <div class="progress-bar-custom">
                            <div class="progress-bar-fill success" style="width: 85%">
                                <span class="progress-bar-text">85%</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="progress-wrapper">
                        <div class="progress-header">
                            <span class="progress-label">Warning (Orange)</span>
                            <span class="progress-percentage">50%</span>
                        </div>
                        <div class="progress-bar-custom">
                            <div class="progress-bar-fill warning" style="width: 50%">
                                <span class="progress-bar-text">50%</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="progress-wrapper">
                        <div class="progress-header">
                            <span class="progress-label">Danger (Rouge)</span>
                            <span class="progress-percentage">25%</span>
                        </div>
                        <div class="progress-bar-custom">
                            <div class="progress-bar-fill danger" style="width: 25%">
                                <span class="progress-bar-text">25%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- 4. Buttons -->
        <section class="demo-section">
            <h2 class="demo-title">🎯 Boutons d'Action</h2>
            
            <div class="demo-grid demo-grid-2">
                <div class="demo-block">
                    <h3 class="demo-block-title">Variantes</h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                        <button class="btn-project primary">
                            <i class="fas fa-check"></i>
                            Primary
                        </button>
                        <button class="btn-project success">
                            <i class="fas fa-save"></i>
                            Success
                        </button>
                        <button class="btn-project warning">
                            <i class="fas fa-exclamation"></i>
                            Warning
                        </button>
                        <button class="btn-project danger">
                            <i class="fas fa-trash"></i>
                            Danger
                        </button>
                        <button class="btn-project outline">
                            <i class="fas fa-edit"></i>
                            Outline
                        </button>
                        <button class="btn-project ghost">
                            <i class="fas fa-times"></i>
                            Ghost
                        </button>
                    </div>
                </div>
                
                <div class="demo-block">
                    <h3 class="demo-block-title">Tailles</h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: center;">
                        <button class="btn-project small primary">Small</button>
                        <button class="btn-project primary">Normal</button>
                        <button class="btn-project large primary">Large</button>
                        <button class="btn-project icon-only primary">
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- 5. Timeline -->
        <section class="demo-section">
            <h2 class="demo-title">📅 Timeline Visuelle</h2>
            
            <div class="demo-block">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <h6 class="timeline-title">Démarrage du Projet</h6>
                                <span class="timeline-date">01/01/2024</span>
                            </div>
                            <p class="timeline-description">
                                Le projet a été officiellement lancé avec succès.
                            </p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-marker success"></div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <h6 class="timeline-title">Phase 1 Complétée</h6>
                                <span class="timeline-date">15/02/2024</span>
                            </div>
                            <p class="timeline-description">
                                Première phase terminée avec 100% d'avancement.
                            </p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-marker warning"></div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <h6 class="timeline-title">Phase 2 En Cours</h6>
                                <span class="timeline-date">01/03/2024</span>
                            </div>
                            <p class="timeline-description">
                                Deuxième phase en cours avec 65% d'avancement.
                            </p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-marker muted"></div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <h6 class="timeline-title">Fin Prévue</h6>
                                <span class="timeline-date">30/06/2024</span>
                            </div>
                            <p class="timeline-description">
                                Date de clôture estimée du projet.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- 6. Project Card -->
        <section class="demo-section">
            <h2 class="demo-title">📦 Card de Projet</h2>
            
            <div class="project-card">
                <div class="project-card-header">
                    <div class="project-card-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <div class="project-card-title">
                        <h3>Rénovation Station de Pompage Nord</h3>
                        <div style="display: flex; gap: 0.5rem; margin-top: 0.5rem;">
                            <span class="badge-status en-cours">
                                <i class="fas fa-circle"></i>
                                En Cours
                            </span>
                            <span class="badge-type">
                                <i class="fas fa-tools"></i>
                                Rénovation
                            </span>
                            <span class="badge-priority haute">Haute</span>
                        </div>
                    </div>
                </div>
                
                <div class="project-card-body">
                    <p class="project-card-description">
                        Modernisation complète de la station de pompage située dans la zone Nord, 
                        incluant le remplacement des équipements obsolètes et l'amélioration du système de distribution.
                    </p>
                    
                    <div class="project-card-meta">
                        <div class="project-meta-item">
                            <i class="fas fa-calendar"></i>
                            <span class="project-meta-label">Début:</span>
                            <span class="project-meta-value">01/01/2024</span>
                        </div>
                        <div class="project-meta-item">
                            <i class="fas fa-coins"></i>
                            <span class="project-meta-label">Budget:</span>
                            <span class="project-meta-value">250,000 TND</span>
                        </div>
                        <div class="project-meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span class="project-meta-label">Zone:</span>
                            <span class="project-meta-value">Zone Nord</span>
                        </div>
                    </div>
                    
                    <div class="progress-wrapper">
                        <div class="progress-header">
                            <span class="progress-label">Avancement Global</span>
                            <span class="progress-percentage">68%</span>
                        </div>
                        <div class="progress-bar-custom">
                            <div class="progress-bar-fill" style="width: 68%">
                                <span class="progress-bar-text">68%</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="project-card-footer">
                    <button class="btn-project small primary">
                        <i class="fas fa-eye"></i>
                        Voir Détails
                    </button>
                    <button class="btn-project small outline">
                        <i class="fas fa-edit"></i>
                        Modifier
                    </button>
                </div>
            </div>
        </section>
        
        <!-- 7. Budget Chart -->
        <section class="demo-section">
            <h2 class="demo-title">💰 Graphique Budget</h2>
            
            <div class="budget-chart">
                <div class="budget-chart-header">
                    <h5 class="budget-chart-title">
                        <i class="fas fa-chart-pie"></i>
                        Budget du Projet
                    </h5>
                    <p class="budget-chart-subtitle">
                        Répartition et suivi des financements
                    </p>
                </div>
                
                <div class="budget-row">
                    <div class="budget-row-header">
                        <span class="budget-row-label">
                            <i class="fas fa-wallet"></i>
                            Budget Prévu
                        </span>
                        <span class="budget-row-amount">
                            250,000
                            <span class="currency">TND</span>
                        </span>
                    </div>
                    <div class="budget-bar">
                        <div class="budget-bar-segment prevu" style="width: 100%">
                            <span class="budget-bar-segment-text">250,000 TND</span>
                        </div>
                    </div>
                </div>
                
                <div class="budget-row">
                    <div class="budget-row-header">
                        <span class="budget-row-label">
                            <i class="fas fa-check-circle"></i>
                            Financements Reçus
                        </span>
                        <span class="budget-row-amount">
                            175,000
                            <span class="currency">TND</span>
                        </span>
                    </div>
                    <div class="budget-bar">
                        <div class="budget-bar-segment recu" style="width: 70%">
                            <span class="budget-bar-segment-text">175,000 TND (70%)</span>
                        </div>
                    </div>
                </div>
                
                <div class="budget-row">
                    <div class="budget-row-header">
                        <span class="budget-row-label">
                            <i class="fas fa-clock"></i>
                            Restant à Financer
                        </span>
                        <span class="budget-row-amount">
                            75,000
                            <span class="currency">TND</span>
                        </span>
                    </div>
                    <div class="budget-bar">
                        <div class="budget-bar-segment restant" style="width: 30%">
                            <span class="budget-bar-segment-text">75,000 TND (30%)</span>
                        </div>
                    </div>
                </div>
                
                <div class="budget-stats">
                    <div class="budget-stat-card">
                        <div class="budget-stat-label">Objectif Total</div>
                        <div class="budget-stat-value">
                            250,000
                            <span class="budget-stat-currency">TND</span>
                        </div>
                    </div>
                    <div class="budget-stat-card">
                        <div class="budget-stat-label">Collecté</div>
                        <div class="budget-stat-value success">
                            175,000
                            <span class="budget-stat-currency">TND</span>
                        </div>
                    </div>
                    <div class="budget-stat-card">
                        <div class="budget-stat-label">Restant</div>
                        <div class="budget-stat-value warning">
                            75,000
                            <span class="budget-stat-currency">TND</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- 8. Utilities -->
        <section class="demo-section">
            <h2 class="demo-title">🛠️ Utilitaires</h2>
            
            <div class="demo-grid demo-grid-2">
                <div class="demo-block">
                    <h3 class="demo-block-title">Hover Effects</h3>
                    <div style="display: grid; gap: 1rem;">
                        <div class="hover-lift" style="background: var(--bg); padding: 1rem; border-radius: 8px; text-align: center;">
                            Hover Lift
                        </div>
                        <div class="hover-scale" style="background: var(--bg); padding: 1rem; border-radius: 8px; text-align: center;">
                            Hover Scale
                        </div>
                        <div class="hover-glow" style="background: var(--bg); padding: 1rem; border-radius: 8px; text-align: center;">
                            Hover Glow
                        </div>
                    </div>
                </div>
                
                <div class="demo-block">
                    <h3 class="demo-block-title">Empty State</h3>
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <h3 class="empty-state-title">Aucun projet trouvé</h3>
                        <p class="empty-state-description">
                            Commencez par créer votre premier projet
                        </p>
                        <button class="btn-project primary">
                            <i class="fas fa-plus"></i>
                            Créer un Projet
                        </button>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Footer -->
        <div style="text-align: center; padding: 2rem; color: var(--muted);">
            <p>AquaSecure - Project Module CSS Demo</p>
            <p style="font-size: 0.9rem;">Version 1.0 - {{ date('Y') }}</p>
        </div>
    </div>
</body>
</html>
