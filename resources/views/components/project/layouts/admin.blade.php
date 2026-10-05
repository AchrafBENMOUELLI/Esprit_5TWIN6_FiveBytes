<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gestion Projets') - AquaSecure Admin</title>
    
    {{-- Bootstrap CSS --}}
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    
    {{-- Styles de base et layout --}}
    <style>
        {!! file_get_contents(resource_path('views/base.css')) !!}
        {!! file_get_contents(resource_path('views/components/dashboard/dashboardsidebar.css')) !!}
        {!! file_get_contents(resource_path('views/components/dashboard/dashboardnavbar.css')) !!}
        {!! file_get_contents(resource_path('views/components/project/layouts/admin.css')) !!}
        {!! file_get_contents(resource_path('views/components/project/project.css')) !!}
    </style>
    
    {{-- Styles personnalisés de la page --}}
    @stack('styles')
</head>
<body>
    {{-- Sidebar --}}
    <x-dashboard.dashboardsidebar />
    
    {{-- Navbar du dashboard --}}
    <x-dashboard.dashboardnavbar />
    
    {{-- Contenu principal --}}
    <main class="aq-admin-main">
        {{-- Fil d'Ariane --}}
        @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
        <nav class="aq-breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            @foreach($breadcrumbs as $breadcrumb)
                <span class="aq-breadcrumb-separator">›</span>
                @if(isset($breadcrumb['url']))
                    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                @else
                    <span class="aq-breadcrumb-current">{{ $breadcrumb['label'] }}</span>
                @endif
            @endforeach
        </nav>
        @endif
        
        {{-- En-tête de la page --}}
        @if(isset($header))
        <div class="aq-page-header">
            <div class="aq-page-header-content">
                <h1 class="aq-page-title">@yield('page-title', $header)</h1>
                @if(isset($description))
                    <p class="aq-page-description">{{ $description }}</p>
                @endif
            </div>
            @if(isset($headerActions))
                <div class="aq-page-actions">
                    {{ $headerActions }}
                </div>
            @endif
        </div>
        @endif
        
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
        <div class="aq-page-content">
            @yield('content')
        </div>
    </main>
    
    {{-- Scripts --}}
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
