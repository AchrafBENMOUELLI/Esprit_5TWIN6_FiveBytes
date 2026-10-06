<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Gestion Projets' }} - AquaSecure Admin</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    {{-- Styles personnalisés --}}
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .aq-admin-main {
            padding: 2rem;
            margin-left: 0;
        }

        @media (min-width: 992px) {
            .aq-admin-main {
                margin-left: 250px;
            }
        }
    </style>

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

    {{-- Messages flash - Bootstrap Toasts --}}
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1090;">
        @if(session('success'))
            <div class="toast show" role="alert" data-bs-delay="5000">
                <div class="toast-header bg-success text-white">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong class="me-auto">Succès</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="toast show" role="alert" data-bs-delay="5000">
                <div class="toast-header bg-danger text-white">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong class="me-auto">Erreur</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if(session('warning'))
            <div class="toast show" role="alert" data-bs-delay="5000">
                <div class="toast-header bg-warning text-dark">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong class="me-auto">Attention</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    {{ session('warning') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="toast show" role="alert" data-bs-delay="10000">
                <div class="toast-header bg-danger text-white">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong class="me-auto">Erreurs de validation</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>

    {{-- Contenu de la page --}}
    <div class="aq-page-content">
        {{ $slot }}
    </div>
    </main>

    {{-- Bootstrap 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
