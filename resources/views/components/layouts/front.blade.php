<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Portail Citoyen' }} - {{ config('app.name', 'AquaSecure') }}</title>

    <!-- Tailwind CSS via CDN (pour composants spécifiques) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>
<body>
    <!-- Navbar Component -->
    <x-shared.navbar-front />
    
    <!-- Page Content -->
    <main style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">
        <!-- Flash Messages -->
        @if (session('success'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 5000)"
                 style="margin-bottom: 1.5rem; background: #ecfdf5; border: 1px solid #10b981; border-left: 4px solid #10b981; padding: 1rem; border-radius: 0.5rem;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; color: #065f46;">
                        <svg style="width: 1.25rem; height: 1.25rem; margin-right: 0.75rem;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p style="font-weight: 500;">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" style="color: #059669; cursor: pointer; background: none; border: none;">
                        <svg style="width: 1.25rem; height: 1.25rem;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 5000)"
                 style="margin-bottom: 1.5rem; background: #fef2f2; border: 1px solid #ef4444; border-left: 4px solid #ef4444; padding: 1rem; border-radius: 0.5rem;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; color: #991b1b;">
                        <svg style="width: 1.25rem; height: 1.25rem; margin-right: 0.75rem;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <p style="font-weight: 500;">{{ session('error') }}</p>
                    </div>
                    <button @click="show = false" style="color: #dc2626; cursor: pointer; background: none; border: none;">
                        <svg style="width: 1.25rem; height: 1.25rem;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div x-data="{ show: true }" 
                 x-show="show"
                 style="margin-bottom: 1.5rem; background: #fef2f2; border: 1px solid #ef4444; border-left: 4px solid #ef4444; padding: 1rem; border-radius: 0.5rem;">
                <div style="display: flex; align-items-start: justify-content: space-between;">
                    <div style="flex: 1;">
                        <div style="display: flex; align-items: center; margin-bottom: 0.5rem; color: #991b1b;">
                            <svg style="width: 1.25rem; height: 1.25rem; margin-right: 0.75rem;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <p style="font-weight: 500;">Erreurs de validation :</p>
                        </div>
                        <ul style="list-style: disc; list-style-position: inside; color: #dc2626; font-size: 0.875rem; margin-left: 2rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button @click="show = false" style="color: #dc2626; cursor: pointer; background: none; border: none; margin-left: 1rem;">
                        <svg style="width: 1.25rem; height: 1.25rem;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <!-- Page Content Slot -->
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer style="background: var(--navy); border-top: 3px solid var(--aqua); margin-top: 3rem; padding: 2rem 1rem;">
        <div style="max-width: 1200px; margin: 0 auto; text-align: center; color: var(--white);">
            <p style="font-size: 0.875rem; opacity: 0.9;">&copy; {{ date('Y') }} AquaSecure. Tous droits réservés.</p>
            <p style="font-size: 0.875rem; margin-top: 0.5rem; color: var(--aqua);">Portail Citoyen - Gestion des incidents d'eau</p>
        </div>
    </footer>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</body>
</html>
