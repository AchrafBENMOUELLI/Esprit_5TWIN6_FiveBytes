<style>{!! file_get_contents(resource_path('views/base.css')) !!}</style>
<style>{!! file_get_contents(resource_path('views/components/drought/drought.css')) !!}</style>

<x-shared.navbar />

<main class="aq-main">
    <div class="aq-drought-container">
        <div class="aq-drought-header">
            <h1>🌊 Gestion 4 - Sécheresse & Consommation d'Eau</h1>
            <p>Surveillance des niveaux d'eau, consommation et restrictions</p>
        </div>

        @if(auth()->check())
            <div class="aq-card" style="margin-bottom: 2rem; background: var(--bg);">
                <h2>Bienvenue {{ auth()->user()->name }}</h2>
                <p style="color: var(--muted);">Rôle: <strong>{{ ucfirst(auth()->user()->role) }}</strong></p>
            </div>

            @if(auth()->user()->role === 'gestionnaire' || auth()->user()->role === 'admin')
                <div class="aq-drought-admin-menu">
                    <h2 style="color: var(--navy); width: 100%; margin-bottom: 1rem;">📊 Interface Gestionnaire</h2>
                    
                    <a href="{{ route('admin.drought.restrictions.index') }}" class="aq-btn aq-btn-primary">
                        📋 Gérer les Restrictions
                    </a>
                    <a href="{{ route('admin.drought.water-levels.index') }}" class="aq-btn aq-btn-info">
                        💧 Niveaux d'Eau
                    </a>
                    <a href="{{ route('admin.drought.consumption.index') }}" class="aq-btn aq-btn-info">
                        📊 Consommation d'Eau
                    </a>
                    <a href="{{ route('admin.drought.scheduled-cuts.index') }}" class="aq-btn aq-btn-warning">
                        ✂️ Coupures Planifiées
                    </a>
                </div>
            @endif

            @if(auth()->user()->role === 'citoyen')
                <div class="aq-drought-citizen-menu">
                    <h2 style="color: var(--navy); width: 100%; margin-bottom: 1rem;">👥 Interface Citoyen</h2>
                    
                    <a href="{{ route('front.drought.dashboard') }}" class="aq-btn aq-btn-secondary">
                        📊 Tableau de Bord
                    </a>
                    <a href="{{ route('front.drought.scheduled-cuts') }}" class="aq-btn aq-btn-secondary">
                        📅 Calendrier des Coupures
                    </a>
                    <a href="{{ route('front.drought.subscriptions') }}" class="aq-btn aq-btn-secondary">
                        🔔 Mes Alertes
                    </a>
                </div>
            @endif

            <div class="aq-card" style="margin-top: 2rem; border-left: 4px solid var(--ocean);">
                <h3>ℹ️ Information</h3>
                <p>Cette section vous permet de gérer la sécheresse et la consommation d'eau.</p>
                <ul style="margin-left: 1.5rem;">
                    <li><strong>Gestionnaires</strong> : Créez des restrictions, enregistrez les niveaux d'eau et planifiez les coupures</li>
                    <li><strong>Citoyens</strong> : Consultez les alertes, le calendrier des coupures et abonnez-vous aux notifications</li>
                </ul>
            </div>
        @else
            <div class="aq-card">
                <h2>Connexion requise</h2>
                <p>Veuillez vous <a href="{{ route('login') }}" style="color: var(--ocean);">connecter</a> pour accéder à la Gestion 4.</p>
            </div>
        @endif
    </div>
</main>

<x-shared.footer />
