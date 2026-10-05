<style>
.infra-module { font-family: 'Segoe UI', sans-serif; }
.infra-module h1 { color: #0b2545; font-size: 1.6rem; margin-bottom: 0.25rem; }
.infra-module .subtitle { color: #64748b; font-size: 0.95rem; margin-bottom: 2rem; }
.infra-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; }
.infra-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(26,115,232,0.08);
    padding: 2rem 1.75rem;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    transition: box-shadow 0.2s, transform 0.2s;
    border-top: 4px solid #1a73e8;
}
.infra-card:hover { box-shadow: 0 6px 24px rgba(26,115,232,0.18); transform: translateY(-3px); }
.infra-card-icon {
    width: 52px; height: 52px;
    background: #e8f0fe;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem;
}
.infra-card h2 { color: #0b2545; font-size: 1.15rem; margin: 0; }
.infra-card p { color: #64748b; font-size: 0.9rem; margin: 0; line-height: 1.5; }
.infra-card .infra-card-action {
    margin-top: auto;
    font-size: 0.85rem;
    color: #1a73e8;
    font-weight: 600;
    display: flex; align-items: center; gap: 0.3rem;
}
</style>

<div class="infra-module">
    <h1>Gestion de l'Infrastructure</h1>
    <p class="subtitle">Gérez les zones, les infrastructures hydrauliques et les maintenances.</p>

    <div class="infra-cards">
        <a href="{{ route('admin.infrastructure.zones.index') }}" class="infra-card">
            <div class="infra-card-icon">🗺️</div>
            <h2>Zones</h2>
            <p>Gérez les zones géographiques de distribution d'eau : communes, codes postaux et populations desservies.</p>
            <span class="infra-card-action">Gérer les zones →</span>
        </a>

        <a href="{{ route('admin.infrastructure.infrastructures.index') }}" class="infra-card">
            <div class="infra-card-icon">🏗️</div>
            <h2>Infrastructures</h2>
            <p>Suivez les canalisations, réservoirs, stations de pompage, captages et compteurs avec leur statut opérationnel.</p>
            <span class="infra-card-action">Gérer les infrastructures →</span>
        </a>

        <a href="{{ route('admin.infrastructure.maintenances.index') }}" class="infra-card">
            <div class="infra-card-icon">🔧</div>
            <h2>Maintenances</h2>
            <p>Planifiez et suivez les interventions de maintenance préventive, corrective et d'urgence sur les infrastructures.</p>
            <span class="infra-card-action">Gérer les maintenances →</span>
        </a>
    </div>
</div>
