<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<style>
    {!! file_get_contents(resource_path('views/base.css')) !!}
    {!! file_get_contents(resource_path('views/components/shared/navbar.css')) !!}
</style>

<style>
    .aq-navbar-front {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 40px;
        background: var(--navy);
        border-bottom: 3px solid var(--aqua);
    }

    .aq-navbar-left {
        display: flex;
        align-items: center;
        gap: 40px;
    }

    .aq-navbar-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .aq-nav-links {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .aq-nav-link {
        padding: 8px 16px;
        border-radius: 6px;
        color: var(--white);
        font-weight: 500;
        transition: background 0.2s, color 0.2s;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.95rem;
    }

    .aq-nav-link:hover {
        background: rgba(255, 255, 255, 0.1);
        color: var(--aqua);
    }

    .aq-nav-link.active {
        background: var(--aqua);
        color: var(--navy);
    }

    .aq-nav-link svg {
        width: 18px;
        height: 18px;
    }

    .aq-user-badge {
        padding: 8px 16px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 6px;
        color: var(--aqua);
        font-size: 0.9rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .aq-user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--aqua);
        color: var(--navy);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.95rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .aq-navbar-front {
            padding: 12px 20px;
        }
        
        .aq-nav-links {
            display: none;
        }
        
        .aq-navbar-left {
            gap: 20px;
        }
    }
</style>

<nav class="aq-navbar-front">
    <div class="aq-navbar-left">
        <a href="{{ route('front.home') }}" class="aq-brand">
            <img src="" alt="Logo AquaSecure">
            <span>AquaSecure</span>
        </a>

        <div class="aq-nav-links">
            <a href="{{ route('front.home') }}" 
               class="aq-nav-link {{ request()->routeIs('front.home') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Accueil
            </a>

            <a href="{{ route('front.incidents.index') }}" 
               class="aq-nav-link {{ request()->routeIs('front.incidents.index', 'front.incidents.show', 'front.incidents.edit') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                Mes incidents
            </a>

            <a href="{{ route('front.incidents.create') }}" 
               class="aq-nav-link {{ request()->routeIs('front.incidents.create') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Signaler
            </a>
        </div>
    </div>

    <div class="aq-navbar-right">
        <div class="aq-user-badge">
            <div class="aq-user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <span>{{ auth()->user()->name }}</span>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="aq-login">Déconnexion</button>
        </form>
    </div>
</nav>
