<x-layouts.front>
    <x-slot name="title">Signaler un incident</x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Signaler un incident</h1>
                <p class="mt-1 text-sm text-gray-600">Décrivez le problème rencontré pour que nous puissions intervenir</p>
            </div>
            <a href="{{ route('front.incidents.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour à mes incidents
            </a>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <form method="POST" action="{{ route('front.incidents.store') }}">
                @csrf

                <div class="space-y-6">
                    <!-- Type et Urgence -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">
                                Type d'incident <span class="text-red-500">*</span>
                            </label>
                            <select name="type" 
                                    id="type" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('type') border-red-500 @enderror">
                                <option value="">Sélectionnez un type</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->value }}" {{ old('type') == $type->value ? 'selected' : '' }}>
                                        {{ $type->label() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Urgence -->
                        <div>
                            <label for="urgence" class="block text-sm font-medium text-gray-700 mb-1">
                                Niveau d'urgence <span class="text-red-500">*</span>
                            </label>
                            <select name="urgence" 
                                    id="urgence" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('urgence') border-red-500 @enderror">
                                <option value="">Sélectionnez l'urgence</option>
                                @foreach($urgences as $urgence)
                                    <option value="{{ $urgence->value }}" {{ old('urgence') == $urgence->value ? 'selected' : '' }}>
                                        {{ $urgence->label() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('urgence')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4" 
                                  placeholder="Décrivez l'incident en détail (minimum 10 caractères)..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Infrastructure (optionnel) -->
                    <div>
                        <label for="infrastructure_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Infrastructure concernée (optionnel)
                        </label>
                        <select name="infrastructure_id" 
                                id="infrastructure_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('infrastructure_id') border-red-500 @enderror">
                            <option value="">Aucune infrastructure</option>
                            @foreach($infrastructures as $infrastructure)
                                <option value="{{ $infrastructure->id }}" {{ old('infrastructure_id') == $infrastructure->id ? 'selected' : '' }}>
                                    {{ $infrastructure->nom }} ({{ $infrastructure->type }})
                                </option>
                            @endforeach
                        </select>
                        @error('infrastructure_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Localisation -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Localisation <span class="text-red-500">*</span>
                        </label>
                        <p class="text-sm text-gray-600 mb-2">Cliquez sur la carte pour indiquer l'emplacement exact de l'incident</p>
                        
                        <!-- Carte Leaflet -->
                        <div id="map" class="h-96 rounded-lg border border-gray-300 mb-4"></div>

                        <!-- Coordonnées -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="latitude" class="block text-sm font-medium text-gray-700 mb-1">
                                    Latitude <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       step="0.0000001" 
                                       name="latitude" 
                                       id="latitude" 
                                       value="{{ old('latitude', '36.8065') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('latitude') border-red-500 @enderror">
                                @error('latitude')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="longitude" class="block text-sm font-medium text-gray-700 mb-1">
                                    Longitude <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       step="0.0000001" 
                                       name="longitude" 
                                       id="longitude" 
                                       value="{{ old('longitude', '10.1815') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('longitude') border-red-500 @enderror">
                                @error('longitude')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="flex gap-3 pt-6 border-t border-gray-200 mt-6">
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Envoyer le signalement
                    </button>
                    <a href="{{ route('front.incidents.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition duration-150">
                        Annuler
                    </a>
                </div>
            </form>
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-medium text-blue-800">Information</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <p>Votre signalement sera traité dans les plus brefs délais. Vous recevrez une notification une fois qu'un technicien sera affecté à votre incident.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Leaflet -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');
        
        const initialLat = parseFloat(latInput.value) || 36.8065;
        const initialLng = parseFloat(lngInput.value) || 10.1815;
        
        const map = L.map('map').setView([initialLat, initialLng], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);
        
        let marker = L.marker([initialLat, initialLng], {
            draggable: true
        }).addTo(map);
        
        function updateCoordinates(lat, lng) {
            latInput.value = lat.toFixed(7);
            lngInput.value = lng.toFixed(7);
        }
        
        map.on('click', function(e) {
            const { lat, lng } = e.latlng;
            marker.setLatLng([lat, lng]);
            updateCoordinates(lat, lng);
        });
        
        marker.on('dragend', function(e) {
            const { lat, lng } = e.target.getLatLng();
            updateCoordinates(lat, lng);
        });
        
        latInput.addEventListener('change', function() {
            const lat = parseFloat(this.value);
            const lng = parseFloat(lngInput.value);
            if (!isNaN(lat) && !isNaN(lng)) {
                marker.setLatLng([lat, lng]);
                map.setView([lat, lng]);
            }
        });
        
        lngInput.addEventListener('change', function() {
            const lat = parseFloat(latInput.value);
            const lng = parseFloat(this.value);
            if (!isNaN(lat) && !isNaN(lng)) {
                marker.setLatLng([lat, lng]);
                map.setView([lat, lng]);
            }
        });
    });
    </script>
</x-layouts.admin>
