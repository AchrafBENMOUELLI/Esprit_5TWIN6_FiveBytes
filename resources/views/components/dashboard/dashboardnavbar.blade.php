<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<style>
    {!! file_get_contents(resource_path('views/base.css')) !!}
    {!! file_get_contents(resource_path('views/components/dashboard/dashboardnavbar.css')) !!}
</style>

<header class="aq-dnav">
    <h2 class="aq-dnav-title">Bureau d'administration</h2>

    <div class="aq-dnav-user">
        <div class="aq-dnav-info">
            <strong>{{ auth()->user()->name }}</strong>
            <span>{{ ucfirst(auth()->user()->role->value) }}</span>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="aq-dnav-logout">Déconnexion</button>
        </form>
    </div>
</header>
