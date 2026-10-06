<style>{!! file_get_contents(resource_path('views/base.css')) !!}</style>
<style>{!! file_get_contents(resource_path('views/components/drought/drought.css')) !!}</style>

<x-shared.navbar />

<main class="aq-main">
    <div class="aq-drought-container">
        <div class="aq-drought-header">
            <h1>🌊 Gestion 4 - Test CRUD</h1>
            <p>Testez la gestion complète des restrictions d'eau</p>
        </div>

        @if(auth()->check())
            <div class="aq-card" style="margin-bottom: 2rem; background: var(--bg);">
                <h2>Bienvenue {{ auth()->user()->name }}</h2>
                <p style="color: var(--muted);">Testez directement le CRUD ci-dessous :</p>
            </div>

            <div class="aq-drought-admin-menu">
                <a href="{{ route('admin.drought.restrictions.index') }}" class="aq-btn aq-btn-primary">
                    📋 Restrictions (CRUD)
                </a>
                <a href="{{ route('admin.drought.water-levels.index') }}" class="aq-btn aq-btn-info">
                    💧 Niveaux d'Eau
                </a>
                <a href="{{ route('admin.drought.consumption.index') }}" class="aq-btn aq-btn-info">
                    📊 Consommation
                </a>
                <a href="{{ route('admin.drought.scheduled-cuts.index') }}" class="aq-btn aq-btn-warning">
                    ✂️ Coupures Planifiées
                </a>
            </div>
        @else
            <div class="aq-card">
                <h2>Connexion requise</h2>
                <p>Veuillez vous <a href="{{ route('login') }}" style="color: var(--ocean);">connecter</a> pour accéder à Gestion 4.</p>
            </div>
        @endif
    </div>
</main>

<x-shared.footer />
