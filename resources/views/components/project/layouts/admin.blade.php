@props(['title', 'breadcrumbs'])

<div class="aq-admin-content">
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
</div>
