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

    <div style="display: flex; gap: 1rem; align-items: center;">
        @auth
            <a href="{{ route('drought.test') }}" style="color: var(--navy); text-decoration: none; font-weight: 500;">Gestion 4</a>
        @endauth

        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="aq-login">Déconnexion</button>
            </form>
        @else
            @unless (request()->routeIs('login', 'register'))
                <a href="{{ route('login') }}" class="aq-login">Connexion</a>
            @endunless
        @endauth
    </div>
</nav>
