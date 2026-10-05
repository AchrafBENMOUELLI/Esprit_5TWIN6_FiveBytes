<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<style>
    {!! file_get_contents(resource_path('views/base.css')) !!}
    {!! file_get_contents(resource_path('views/components/shared/navbar.css')) !!}
</style>

<nav class="aq-navbar">
    <a href="{{ url('/') }}" class="aq-brand">
        <img src="" alt="Logo AquaSecure">
        <span>AquaSecure</span>
    </a>

    <div class="aq-nav-links">
        {{-- Navigation pour tous --}}
        <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Accueil</a>

        @auth
            @if(Auth::user()->role === App\Enums\UserRole::Citoyen)
                {{-- Navigation pour Citoyens --}}
                <a href="{{ route('project.index') }}" class="{{ request()->routeIs('project.*') ? 'active' : '' }}">
                    Nos Projets
                </a>
                {{-- Les autres modules seront ajoutés par vos collègues --}}
                {{-- <a href="{{ route('front.infrastructure.index') }}">Infrastructures</a> --}}
                {{-- <a href="{{ route('front.incident.index') }}">Signaler un Incident</a> --}}
                {{-- <a href="{{ route('front.quality.index') }}">Qualité de l'Eau</a> --}}
                {{-- <a href="{{ route('front.drought.index') }}">Alertes Sécheresse</a> --}}
            @elseif(Auth::user()->role === App\Enums\UserRole::Gestionnaire || Auth::user()->role === App\Enums\UserRole::Admin)
                {{-- Navigation pour Gestionnaires et Admins --}}
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
                {{-- TODO: Uncomment when admin routes are created --}}
                {{-- <a href="{{ route('admin.project.index') }}" class="{{ request()->routeIs('admin.project.*') ? 'active' : '' }}">
                    Projets
                </a> --}}
                {{-- Les autres modules admin seront ajoutés par vos collègues --}}
                {{-- <a href="{{ route('admin.infrastructure.index') }}">Infrastructures</a> --}}
                {{-- <a href="{{ route('admin.incident.index') }}">Incidents</a> --}}
                {{-- <a href="{{ route('admin.quality.index') }}">Qualité</a> --}}
                {{-- <a href="{{ route('admin.drought.index') }}">Sécheresse</a> --}}
            @endif

            {{-- Bouton déconnexion --}}
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="aq-login">
                    {{ Auth::user()->name }} - Déconnexion
                </button>
            </form>
        @else
            {{-- Navigation pour visiteurs non authentifiés --}}
            <a href="{{ route('project.index') }}" class="{{ request()->routeIs('project.*') ? 'active' : '' }}">
                Projets de Rénovation
            </a>
            
            @unless (request()->routeIs('login', 'register'))
                <a href="{{ route('login') }}" class="aq-login">Connexion</a>
            @endunless
        @endauth
    </div>
</nav>
