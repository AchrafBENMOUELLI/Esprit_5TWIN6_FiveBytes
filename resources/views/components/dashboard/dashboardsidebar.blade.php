<style>{!! file_get_contents(resource_path('views/components/dashboard/dashboardsidebar.css')) !!}</style>

<aside class="aq-sidebar">
    <a href="{{ url('/') }}" class="aq-sidebar-brand">
        <img src="" alt="Logo AquaSecure">
        <span>AquaSecure</span>
    </a>

    <nav class="aq-sidebar-menu">
        <a href="{{ route('dashboard') }}" class="{{ request('module') ? '' : 'active' }}">Tableau de bord</a>
        <p class="aq-sidebar-label">Modules</p>
        <a href="{{ route('dashboard', ['module' => 'infrastructure']) }}" class="{{ request('module') === 'infrastructure' ? 'active' : '' }}">Infrastructure</a>
        <a href="{{ auth()->user()->role === \App\Enums\UserRole::Citoyen ? route('front.incidents.index') : route('admin.incidents.index') }}" class="{{ request()->routeIs('*.incidents.*') ? 'active' : '' }}">Incidents</a>
        <a href="{{ route('dashboard', ['module' => 'quality']) }}" class="{{ request('module') === 'quality' ? 'active' : '' }}">Qualité de l'eau</a>
        <a href="{{ route('dashboard', ['module' => 'drought']) }}" class="{{ request('module') === 'drought' ? 'active' : '' }}">Sécheresse</a>
        <a href="{{ route('dashboard', ['module' => 'project']) }}" class="{{ request('module') === 'project' ? 'active' : '' }}">Projets</a>

        @if (auth()->user()->role === \App\Enums\UserRole::Admin)
            <p class="aq-sidebar-label">Administration</p>
            <a href="#">Utilisateurs</a>
        @endif
    </nav>
</aside>
