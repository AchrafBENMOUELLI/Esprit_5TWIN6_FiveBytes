<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Projets de Rénovation') - AquaSecure</title>
    
    {{-- Bootstrap CSS --}}
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    
    {{-- Styles de base --}}
    <style>
        {!! file_get_contents(resource_path('views/base.css')) !!}
        {!! file_get_contents(resource_path('views/components/project/layouts/front.css')) !!}
        {!! file_get_contents(resource_path('views/components/project/project.css')) !!}
    </style>
    
    {{-- Styles personnalisés de la page --}}
    @stack('styles')
</head>
<body>
    {{-- Navbar --}}
    <x-shared.navbar />
    
    {{-- Contenu principal --}}
    <main class="aq-front-main">
        {{-- Hero Section (optionnel) --}}
        @if(isset($hero))
        <section class="aq-hero">
            <div class="aq-hero-content">
                <h1 class="aq-hero-title">{{ $hero['title'] ?? 'Projets de Rénovation' }}</h1>
                @if(isset($hero['description']))
                    <p class="aq-hero-description">{{ $hero['description'] }}</p>
                @endif
            </div>
        </section>
        @endif
        
        {{-- Container --}}
        <div class="aq-container">
            {{-- Messages flash --}}
            @if(session('success'))
                <div class="aq-alert aq-alert-success">
                    <svg class="aq-alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <div class="aq-alert-content">
                        <strong>Succès !</strong>
                        <p>{{ session('success') }}</p>
                    </div>
                    <button type="button" class="aq-alert-close" onclick="this.parentElement.remove()">×</button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="aq-alert aq-alert-error">
                    <svg class="aq-alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="aq-alert-content">
                        <strong>Erreur !</strong>
                        <p>{{ session('error') }}</p>
                    </div>
                    <button type="button" class="aq-alert-close" onclick="this.parentElement.remove()">×</button>
                </div>
            @endif
            
            @if(session('warning'))
                <div class="aq-alert aq-alert-warning">
                    <svg class="aq-alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div class="aq-alert-content">
                        <strong>Attention !</strong>
                        <p>{{ session('warning') }}</p>
                    </div>
                    <button type="button" class="aq-alert-close" onclick="this.parentElement.remove()">×</button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="aq-alert aq-alert-error">
                    <svg class="aq-alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="aq-alert-content">
                        <strong>Erreurs de validation</strong>
                        <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="aq-alert-close" onclick="this.parentElement.remove()">×</button>
                </div>
            @endif
            
            {{-- Contenu de la page --}}
            @yield('content')
        </div>
    </main>
    
    {{-- Footer --}}
    <footer class="aq-footer">
        <div class="aq-container">
            <div class="aq-footer-grid">
                <div class="aq-footer-section">
                    <h3 class="aq-footer-title">AquaSecure</h3>
                    <p class="aq-footer-text">
                        Gestion intelligente des ressources en eau pour un avenir durable.
                    </p>
                </div>
                
                <div class="aq-footer-section">
                    <h4 class="aq-footer-subtitle">Navigation</h4>
                    <ul class="aq-footer-links">
                        <li><a href="{{ url('/') }}">Accueil</a></li>
                        <li><a href="{{ route('projects.index') }}">Projets</a></li>
                        @auth
                            <li><a href="{{ route('donations.index') }}">Mes dons</a></li>
                        @endauth
                    </ul>
                </div>
                
                <div class="aq-footer-section">
                    <h4 class="aq-footer-subtitle">Modules</h4>
                    <ul class="aq-footer-links">
                        <li><a href="#">Infrastructure</a></li>
                        <li><a href="#">Incidents</a></li>
                        <li><a href="#">Qualité de l'eau</a></li>
                        <li><a href="#">Sécheresse</a></li>
                    </ul>
                </div>
                
                <div class="aq-footer-section">
                    <h4 class="aq-footer-subtitle">Contact</h4>
                    <ul class="aq-footer-links">
                        <li>Email: contact@aquasecure.tn</li>
                        <li>Tél: +216 XX XXX XXX</li>
                        <li>Adresse: Tunis, Tunisie</li>
                    </ul>
                </div>
            </div>
            
            <div class="aq-footer-bottom">
                <p>&copy; {{ date('Y') }} AquaSecure. Tous droits réservés.</p>
                <div class="aq-footer-bottom-links">
                    <a href="#">Mentions légales</a>
                    <a href="#">Confidentialité</a>
                    <a href="#">CGU</a>
                </div>
            </div>
        </div>
    </footer>
    
    {{-- Scripts --}}
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
