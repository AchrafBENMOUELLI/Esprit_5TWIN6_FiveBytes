<style>{!! file_get_contents(resource_path('views/welcome.css')) !!}</style>

<x-shared.navbar />

<main class="aq-main">
    <h1>Bienvenue sur AquaSecure</h1>
    <p>Surveillance et gestion de l'eau potable.</p>

    @if(auth()->check())
        <div style="margin-top: 2rem;">
            <h2 style="color: var(--navy);">🌊 Testez la Gestion 4</h2>
            <p>Accédez à la gestion complète des restrictions d'eau, niveaux d'eau et consommation.</p>
            <a href="{{ route('drought') }}" style="
                display: inline-block;
                padding: 0.75rem 1.5rem;
                background-color: var(--ocean);
                color: white;
                border-radius: 0.5rem;
                text-decoration: none;
                font-weight: 500;
                transition: all 0.3s ease;
            " onmouseover="this.style.backgroundColor='var(--navy)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.backgroundColor='var(--ocean)'; this.style.transform='translateY(0)';">
                Accéder à la Gestion 4 →
            </a>
        </div>
    @else
        <div style="margin-top: 2rem;">
            <p><a href="{{ route('login') }}" style="color: var(--ocean); text-decoration: none; font-weight: 500;">Se connecter →</a></p>
        </div>
    @endif
</main>

<x-shared.footer />
