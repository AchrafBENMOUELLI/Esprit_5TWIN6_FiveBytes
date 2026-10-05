<x-layouts.admin>
    <x-slot name="title">Incident {{ $incident->reference }}</x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $incident->reference }}</h1>
                <p class="mt-1 text-sm text-gray-600">{{ $incident->type->label() }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.incidents.edit', $incident) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier
                </a>
                <button @click="$dispatch('delete-incident', { id: {{ $incident->id }}, reference: '{{ $incident->reference }}' })" 
                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition duration-150">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Supprimer
                </button>
                <a href="{{ route('admin.incidents.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition duration-150">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informations principales -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Statut et Urgence -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Statut de l'incident</h2>
                        <div class="flex gap-2">
                            <span class="px-3 py-1 text-sm font-medium rounded-full border {{ $incident->urgence->color() }}">
                                {{ $incident->urgence->label() }}
                            </span>
                            <span class="px-3 py-1 text-sm font-medium rounded-full border {{ $incident->statut->color() }}">
                                {{ $incident->statut->label() }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Créé le</span>
                            <p class="font-medium text-gray-900">{{ $incident->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Modifié le</span>
                            <p class="font-medium text-gray-900">{{ $incident->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        @if($incident->date_resolution)
                        <div class="col-span-2">
                            <span class="text-gray-500">Résolu le</span>
                            <p class="font-medium text-green-600">{{ $incident->date_resolution->format('d/m/Y à H:i') }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Description</h2>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $incident->description }}</p>
                </div>

                <!-- Carte de localisation -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Localisation</h2>
                    <div id="map" class="h-96 rounded-lg border border-gray-300 mb-4"></div>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Latitude</span>
                            <p class="font-medium text-gray-900">{{ $incident->latitude }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Longitude</span>
                            <p class="font-medium text-gray-900">{{ $incident->longitude }}</p>
                        </div>
                    </div>
                </div>

                <!-- Incidents liés (doublons) -->
                @if($incident->doublons->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">
                        Incidents liés ({{ $incident->doublons->count() }} doublon(s))
                    </h2>
                    <div class="space-y-2">
                        @foreach($incident->doublons as $doublon)
                        <a href="{{ route('admin.incidents.show', $doublon) }}" 
                           class="block p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition duration-150">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <span class="font-medium text-gray-900">{{ $doublon->reference }}</span>
                                    <span class="text-sm text-gray-600 ml-2">{{ $doublon->type->label() }}</span>
                                </div>
                                <span class="px-2 py-1 text-xs font-medium rounded-full border {{ $doublon->statut->color() }}">
                                    {{ $doublon->statut->label() }}
                                </span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Citoyen -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Signalé par</h2>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">{{ $incident->citoyen->name }}</p>
                            <p class="text-sm text-gray-500">{{ $incident->citoyen->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Technicien -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Technicien affecté</h2>
                    @if($incident->technicien)
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">{{ $incident->technicien->name }}</p>
                            <p class="text-sm text-gray-500">{{ $incident->technicien->email }}</p>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Aucun technicien affecté</p>
                    </div>
                    @endif
                </div>

                <!-- Infrastructure -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Infrastructure</h2>
                    @if($incident->infrastructure)
                    <div>
                        <p class="font-medium text-gray-900">{{ $incident->infrastructure->nom }}</p>
                        <p class="text-sm text-gray-500">Type: {{ $incident->infrastructure->type }}</p>
                        <p class="text-sm text-gray-500">Zone: {{ $incident->infrastructure->zone->nom }}</p>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Aucune infrastructure liée</p>
                    </div>
                    @endif
                </div>

                <!-- Incident parent -->
                @if($incident->parent)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Incident parent</h2>
                    <a href="{{ route('admin.incidents.show', $incident->parent) }}" 
                       class="block p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition duration-150">
                        <div class="font-medium text-blue-900">{{ $incident->parent->reference }}</div>
                        <div class="text-sm text-blue-700">{{ $incident->parent->type->label() }}</div>
                    </a>
                    <p class="mt-2 text-xs text-gray-500">Cet incident est un doublon</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div x-data="{ 
        open: false, 
        incidentId: null, 
        incidentReference: '' 
    }"
         @delete-incident.window="open = true; incidentId = $event.detail.id; incidentReference = $event.detail.reference"
         x-show="open"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="open = false"
                 class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Supprimer l'incident
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Êtes-vous sûr de vouloir supprimer l'incident <strong x-text="incidentReference"></strong> ?
                                    Cette action est irréversible.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                    <form :action="`{{ route('admin.incidents.index') }}/${incidentId}`" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Supprimer
                        </button>
                    </form>
                    <button type="button" 
                            @click="open = false"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Leaflet pour la carte -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const lat = {{ $incident->latitude }};
        const lng = {{ $incident->longitude }};
        
        const map = L.map('map').setView([lat, lng], 15);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);
        
        const marker = L.marker([lat, lng]).addTo(map);
        marker.bindPopup('<strong>{{ $incident->reference }}</strong><br>{{ $incident->type->label() }}').openPopup();
    });
    </script>
</x-layouts.admin>
