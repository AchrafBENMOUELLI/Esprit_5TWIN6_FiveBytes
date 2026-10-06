<style>{!! file_get_contents(resource_path('views/components/drought/drought.css')) !!}</style>

<div class="aq-drought-container">
    <div class="aq-drought-header">
        <h1>Gestion de la Sécheresse</h1>
        <p>Surveillance des niveaux d'eau, consommation et restrictions</p>
    </div>

    @if(auth()->user()->role === \App\Enums\UserRole::Gestionnaire || auth()->user()->role === \App\Enums\UserRole::Admin)
        <div class="aq-drought-admin-menu">
            <a href="{{ route('admin.drought.restrictions.index') }}" class="aq-btn aq-btn-primary">Gérer les Restrictions</a>
            <a href="{{ route('admin.drought.water-levels.index') }}" class="aq-btn aq-btn-primary">Niveaux d'Eau</a>
            <a href="{{ route('admin.drought.consumption.index') }}" class="aq-btn aq-btn-primary">Consommation</a>
            <a href="{{ route('admin.drought.scheduled-cuts.index') }}" class="aq-btn aq-btn-primary">Coupures Planifiées</a>
        </div>
    @endif

    <div class="aq-drought-citizen-menu">
        <a href="{{ route('front.drought.scheduled-cuts') }}" class="aq-btn aq-btn-primary">Calendrier des Coupures</a>
    </div>

    <!-- Zones Dashboard -->
    <div class="aq-drought-header" style="margin-top: 3rem;">
        <h2>Tableau de Bord - Niveaux d'Alerte par Zone</h2>
    </div>

    <div class="aq-grid">
        @php
            $zones = \App\Models\Infrastructure\Zone::whereIn('nom', ['Tunis', 'Bizerte'])->orderBy('nom')->get();
        @endphp
        
        @foreach($zones as $zone)
            <div class="aq-card">
                <h3>{{ $zone->nom }}</h3>
                <p><strong>Commune:</strong> {{ $zone->commune }}</p>
                <p><strong>Population:</strong> {{ number_format($zone->population, 0, ',', ' ') }}</p>
                
                @php
                    $restriction = $zone->restrictions()
                        ->where('date_fin', '>=', now())
                        ->orWhereNull('date_fin')
                        ->latest('date_debut')
                        ->first();
                @endphp

                @if($restriction)
                    <p>
                        <strong>Niveau d'Alerte:</strong><br>
                        <span class="aq-badge aq-badge-{{ $restriction->niveau }}">
                            {{ ucfirst($restriction->niveau) }}
                        </span>
                    </p>
                    <p><strong>Restriction:</strong> {{ $restriction->titre }}</p>
                @else
                    <p>
                        <strong>Niveau d'Alerte:</strong><br>
                        <span class="aq-badge aq-badge-vigilance">Normal</span>
                    </p>
                @endif

                <a href="{{ route('front.drought.zone.alerts', $zone) }}" class="aq-btn aq-btn-secondary" style="width: 100%; text-align: center; margin-top: 1rem;">
                    Voir les détails
                </a>
            </div>
        @endforeach
    </div>
</div>
