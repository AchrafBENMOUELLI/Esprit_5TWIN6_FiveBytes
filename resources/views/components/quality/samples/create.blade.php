@props(['zones', 'infrastructures', 'thresholds'])

<div class="max-w-4xl mx-auto p-6">
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.quality.samples.index') }}" 
               class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Nouvel échantillon d'eau</h2>
                <p class="text-gray-600 text-sm mt-1">Enregistrer une nouvelle analyse de qualité</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.quality.samples.store') }}" class="space-y-6">
        @csrf

        {{-- Informations générales --}}
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informations de prélèvement</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Zone --}}
                <div>
                    <label for="zone_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Zone <span class="text-red-500">*</span>
                    </label>
                    <select name="zone_id" id="zone_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('zone_id') border-red-500 @enderror">
                        <option value="">Sélectionner une zone</option>
                        @foreach($zones as $zone)
                            <option value="{{ $zone->id }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>
                                {{ $zone->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('zone_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Infrastructure --}}
                <div>
                    <label for="infrastructure_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Infrastructure (optionnel)
                    </label>
                    <select name="infrastructure_id" id="infrastructure_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('infrastructure_id') border-red-500 @enderror">
                        <option value="">Aucune infrastructure spécifique</option>
                        @foreach($infrastructures as $infra)
                            <option value="{{ $infra->id }}" {{ old('infrastructure_id') == $infra->id ? 'selected' : '' }}>
                                {{ $infra->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('infrastructure_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Date de prélèvement --}}
                <div>
                    <label for="date_prelevement" class="block text-sm font-medium text-gray-700 mb-2">
                        Date et heure de prélèvement <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" 
                           name="date_prelevement" 
                           id="date_prelevement" 
                           value="{{ old('date_prelevement', now()->format('Y-m-d\TH:i')) }}"
                           max="{{ now()->format('Y-m-d\TH:i') }}"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('date_prelevement') border-red-500 @enderror">
                    @error('date_prelevement')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Paramètres analysés --}}
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Paramètres analysés</h3>
                <span class="text-sm text-gray-600">Au moins un paramètre requis</span>
            </div>

            <div id="parameters-container" class="space-y-4">
                @foreach($thresholds as $index => $threshold)
                    <div class="parameter-row flex items-center gap-4 p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                <span class="font-medium text-gray-800">{{ $threshold->parametre->label() }}</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                Seuils: 
                                @if($threshold->valeur_min)
                                    min {{ $threshold->valeur_min }}
                                @endif
                                @if($threshold->valeur_min && $threshold->valeur_max)
                                    -
                                @endif
                                @if($threshold->valeur_max)
                                    max {{ $threshold->valeur_max }}
                                @endif
                                {{ $threshold->unite }}
                            </p>
                        </div>
                        
                        <div class="w-48">
                            <input type="hidden" 
                                   name="parameters[{{ $index }}][threshold_id]" 
                                   value="{{ $threshold->id }}">
                            <input type="number" 
                                   step="0.001"
                                   name="parameters[{{ $index }}][valeur]" 
                                   value="{{ old("parameters.{$index}.valeur") }}"
                                   placeholder="Valeur"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error("parameters.{$index}.valeur") border-red-500 @enderror">
                        </div>

                        <div class="w-24 text-right">
                            <span class="text-sm text-gray-600">{{ $threshold->unite }}</span>
                        </div>
                    </div>
                    @error("parameters.{$index}.valeur")
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                @endforeach
            </div>

            @error('parameters')
                <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('admin.quality.samples.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-colors">
                Annuler
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Enregistrer l'analyse
            </button>
        </div>
    </form>
</div>
