<style>{!! file_get_contents(resource_path('views/components/drought/drought.css')) !!}</style>

<div class="aq-drought-container">
    <div class="aq-drought-header">
        <h1>Gestion de la Sécheresse</h1>
        <p>Surveillance des niveaux d'eau, consommation et restrictions</p>
    </div>

    @if(auth()->user()->role === \App\Enums\UserRole::Gestionnaire || auth()->user()->role === \App\Enums\UserRole::Admin)
        <div class="aq-drought-admin-menu">
            <a href="{{ route('admin.drought.restrictions.index') }}" class="aq-btn aq-btn-primary">Gérer les Restrictions</a>
            <a href="{{ route('admin.drought.water-levels.index') }}" class="aq-btn aq-btn-info">Niveaux d'Eau</a>
            <a href="{{ route('admin.drought.consumption.index') }}" class="aq-btn aq-btn-info">Consommation</a>
            <a href="{{ route('admin.drought.scheduled-cuts.index') }}" class="aq-btn aq-btn-warning">Coupures Planifiées</a>
        </div>
    @endif

    <div class="aq-drought-citizen-menu">
        <a href="{{ route('front.drought.dashboard') }}" class="aq-btn aq-btn-secondary">Tableau de Bord</a>
        <a href="{{ route('front.drought.scheduled-cuts') }}" class="aq-btn aq-btn-secondary">Calendrier des Coupures</a>
        <a href="{{ route('front.drought.subscriptions') }}" class="aq-btn aq-btn-secondary">Mes Abonnements</a>
    </div>
</div>
