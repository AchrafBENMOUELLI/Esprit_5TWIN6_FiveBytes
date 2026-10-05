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
</nav>
