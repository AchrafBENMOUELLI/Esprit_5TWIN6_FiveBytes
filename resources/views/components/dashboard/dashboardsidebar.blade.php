<style>{!! file_get_contents(resource_path('views/components/dashboard/dashboardsidebar.css')) !!}</style>

@php
    $isInfrastructure = request('module') === 'infrastructure' || request()->is('admin/infrastructure*');
@endphp

<aside class="aq-sidebar">
    <a href="{{ url('/') }}" class="aq-sidebar-brand">
        <img src="" alt="Logo AquaSecure">
        <span>AquaSecure</span>
    </a>

    <nav class="aq-sidebar-menu">
        <a href="{{ route('dashboard') }}" class="{{ (!request('module') && !request()->is('admin/*')) ? 'active' : '' }}">Tableau de bord</a>
        <p class="aq-sidebar-label">Modules</p>

        {{-- Infrastructure avec sous-menu --}}
        <a href="{{ route('dashboard', ['module' => 'infrastructure']) }}"
           class="aq-sidebar-parent {{ $isInfrastructure ? 'active' : '' }}">
            <span>Infrastructure</span>
            <svg class="aq-sidebar-arrow {{ $isInfrastructure ? 'open' : '' }}" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
            </svg>
        </a>
        <div class="aq-sidebar-submenu {{ $isInfrastructure ? 'open' : '' }}">
            <a href="{{ route('admin.infrastructure.zones.index') }}"
               class="{{ request()->routeIs('admin.infrastructure.zones*') ? 'active' : '' }}">
                🗺️ Zones
            </a>
            <a href="{{ route('admin.infrastructure.infrastructures.index') }}"
               class="{{ request()->routeIs('admin.infrastructure.infrastructures*') ? 'active' : '' }}">
                🏗️ Infrastructures
            </a>
            <a href="{{ route('admin.infrastructure.maintenances.index') }}"
               class="{{ request()->routeIs('admin.infrastructure.maintenances*') ? 'active' : '' }}">
                🔧 Maintenances
            </a>
        </div>

        <a href="{{ route('dashboard', ['module' => 'incident']) }}" class="{{ request('module') === 'incident' ? 'active' : '' }}">Incidents</a>
        <a href="{{ route('dashboard', ['module' => 'quality']) }}" class="{{ request('module') === 'quality' ? 'active' : '' }}">Qualité de l'eau</a>
        <a href="{{ route('dashboard', ['module' => 'drought']) }}" class="{{ request('module') === 'drought' ? 'active' : '' }}">Sécheresse</a>
        <a href="{{ route('dashboard', ['module' => 'project']) }}" class="{{ request('module') === 'project' ? 'active' : '' }}">Projets</a>

        @if (auth()->user()->role === \App\Enums\UserRole::Admin)
            <p class="aq-sidebar-label">Administration</p>
            <a href="#">Utilisateurs</a>
        @endif
    </nav>
</aside>
