<x-layouts.front>
    <x-slot name="title">Portail Citoyen</x-slot>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-xl p-8 mb-8 text-white">
        <h1 class="text-4xl font-bold mb-4">👋 Bienvenue, {{ auth()->user()->name }} !</h1>
        <p class="text-xl text-blue-100 mb-6">
            Gérez vos signalements d'incidents liés à l'eau potable en toute simplicité
        </p>
        <a href="{{ route('front.incidents.create') }}" 
           class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition duration-150">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Signaler un incident
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Incidents -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium mb-1">Mes incidents</p>
                    <p class="text-3xl font-bold text-gray-900">
                        {{ auth()->user()->incidentsSignales()->count() }}
                    </p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
            <a href="{{ route('front.incidents.index') }}" class="text-sm text-blue-600 hover:text-blue-800 mt-2 inline-block">
                Voir tous mes incidents →
            </a>
        </div>

        <!-- En Attente -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium mb-1">En attente</p>
                    <p class="text-3xl font-bold text-gray-900">
                        {{ auth()->user()->incidentsSignales()->where('statut', 'nouveau')->count() }}
                    </p>
                </div>
                <div class="bg-yellow-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Résolus -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium mb-1">Résolus</p>
                    <p class="text-3xl font-bold text-gray-900">
                        {{ auth()->user()->incidentsSignales()->where('statut', 'resolu')->count() }}
                    </p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Actions rapides</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('front.incidents.create') }}" 
               class="flex items-center p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition duration-150">
                <div class="bg-blue-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Signaler un incident</h3>
                    <p class="text-sm text-gray-600">Fuite, contamination, coupure...</p>
                </div>
            </a>

            <a href="{{ route('front.incidents.index') }}" 
               class="flex items-center p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition duration-150">
                <div class="bg-purple-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Mes signalements</h3>
                    <p class="text-sm text-gray-600">Suivre l'état de mes incidents</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Informations utiles -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h2 class="text-xl font-bold text-blue-900 mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Comment signaler un incident ?
        </h2>
        <ol class="space-y-3 text-gray-700">
            <li class="flex items-start">
                <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">1</span>
                <span>Cliquez sur "Signaler un incident" dans le menu ou ci-dessus</span>
            </li>
            <li class="flex items-start">
                <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">2</span>
                <span>Choisissez le type d'incident (fuite, contamination, coupure...)</span>
            </li>
            <li class="flex items-start">
                <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">3</span>
                <span>Décrivez le problème en détail et indiquez l'emplacement sur la carte</span>
            </li>
            <li class="flex items-start">
                <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">4</span>
                <span>Un technicien sera assigné et vous serez notifié de l'évolution</span>
            </li>
        </ol>
    </div>
</x-layouts.front>
