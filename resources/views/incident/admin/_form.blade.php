@props(['incident' => null, 'infrastructures', 'techniciens', 'citoyens', 'statuts', 'urgences', 'types', 'incidentsParents' => null])

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
                    <option value="{{ $type->value }}" {{ old('type', $incident?->type?->value) == $type->value ? 'selected' : '' }}>
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
                    <option value="{{ $urgence->value }}" {{ old('urgence', $incident?->urgence?->value) == $urgence->value ? 'selected' : '' }}>
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
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $incident?->description) }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Citoyen (en mode création) -->
    @if(!$incident)
    <div>
        <label for="citoyen_id" class="block text-sm font-medium text-gray-700 mb-1">
            Citoyen <span class="text-red-500">*</span>
        </label>
        <select name="citoyen_id" 
                id="citoyen_id" 
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('citoyen_id') border-red-500 @enderror">
            <option value="">Sélectionnez un citoyen</option>
            @foreach($citoyens as $citoyen)
                <option value="{{ $citoyen->id }}" {{ old('citoyen_id') == $citoyen->id ? 'selected' : '' }}>
                    {{ $citoyen->name }} ({{ $citoyen->email }})
                </option>
            @endforeach
        </select>
        @error('citoyen_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
    @endif

    <!-- Statut et Technicien (en mode édition) -->
    @if($incident)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Statut -->
        <div>
            <label for="statut" class="block text-sm font-medium text-gray-700 mb-1">
                Statut <span class="text-red-500">*</span>
            </label>
            <select name="statut" 
                    id="statut" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('statut') border-red-500 @enderror">
                @foreach($statuts as $statut)
                    <option value="{{ $statut->value }}" {{ old('statut', $incident->statut->value) == $statut->value ? 'selected' : '' }}>
                        {{ $statut->label() }}
                    </option>
                @endforeach
            </select>
            @error('statut')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Technicien -->
        <div>
            <label for="technicien_id" class="block text-sm font-medium text-gray-700 mb-1">
                Technicien affecté
            </label>
            <select name="technicien_id" 
                    id="technicien_id" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('technicien_id') border-red-500 @enderror">
                <option value="">Non affecté</option>
                @foreach($techniciens as $technicien)
                    <option value="{{ $technicien->id }}" {{ old('technicien_id', $incident->technicien_id) == $technicien->id ? 'selected' : '' }}>
                        {{ $technicien->name }}
                    </option>
                @endforeach
            </select>
            @error('technicien_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
    @endif

    <!-- Infrastructure -->
    <div>
        <label for="infrastructure_id" class="block text-sm font-medium text-gray-700 mb-1">
            Infrastructure concernée
        </label>
        <select name="infrastructure_id" 
                id="infrastructure_id" 
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('infrastructure_id') border-red-500 @enderror">
            <option value="">Aucune infrastructure</option>
            @foreach($infrastructures as $infrastructure)
                <option value="{{ $infrastructure->id }}" {{ old('infrastructure_id', $incident?->infrastructure_id) == $infrastructure->id ? 'selected' : '' }}>
                    {{ $infrastructure->nom }} ({{ $infrastructure->type }})
                </option>
            @endforeach
        </select>
        @error('infrastructure_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Incident parent (pour doublons) - en mode édition uniquement -->
    @if($incident && $incidentsParents)
    <div>
        <label for="incident_parent_id" class="block text-sm font-medium text-gray-700 mb-1">
            Incident parent (doublon)
        </label>
        <select name="incident_parent_id" 
                id="incident_parent_id" 
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('incident_parent_id') border-red-500 @enderror">
            <option value="">Aucun (incident indépendant)</option>
            @foreach($incidentsParents as $parent)
                <option value="{{ $parent->id }}" {{ old('incident_parent_id', $incident->incident_parent_id) == $parent->id ? 'selected' : '' }}>
                    {{ $parent->reference }} - {{ $parent->type->label() }}
                </option>
            @endforeach
        </select>
        <p class="mt-1 text-xs text-gray-500">Si cet incident est un doublon d'un autre incident, sélectionnez l'incident parent.</p>
        @error('incident_parent_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
    @endif

    <!-- Localisation -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Localisation <span class="text-red-500">*</span>
        </label>
        <p class="text-sm text-gray-600 mb-2">Cliquez sur la carte pour définir la position de l'incident</p>
        
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
                       value="{{ old('latitude', $incident?->latitude ?? '36.8065') }}"
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
                       value="{{ old('longitude', $incident?->longitude ?? '10.1815') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('longitude') border-red-500 @enderror">
                @error('longitude')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</div>

<!-- Script Leaflet -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    
    // Position initiale (Tunisie - Tunis)
    const initialLat = parseFloat(latInput.value) || 36.8065;
    const initialLng = parseFloat(lngInput.value) || 10.1815;
    
    // Initialiser la carte
    const map = L.map('map').setView([initialLat, initialLng], 13);
    
    // Ajouter le layer OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);
    
    // Marqueur
    let marker = L.marker([initialLat, initialLng], {
        draggable: true
    }).addTo(map);
    
    // Fonction pour mettre à jour les coordonnées
    function updateCoordinates(lat, lng) {
        latInput.value = lat.toFixed(7);
        lngInput.value = lng.toFixed(7);
    }
    
    // Clic sur la carte
    map.on('click', function(e) {
        const { lat, lng } = e.latlng;
        marker.setLatLng([lat, lng]);
        updateCoordinates(lat, lng);
    });
    
    // Drag du marqueur
    marker.on('dragend', function(e) {
        const { lat, lng } = e.target.getLatLng();
        updateCoordinates(lat, lng);
    });
    
    // Mise à jour de la carte quand on change les inputs
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
