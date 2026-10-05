@props(['alerts'])

<div class="max-w-7xl mx-auto p-6">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Alertes qualité</h2>
            <p class="text-gray-600 text-sm mt-1">Alertes actives nécessitant une attention</p>
        </div>
        <a href="{{ route('admin.quality.samples.index') }}" 
           class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
            Retour aux échantillons
        </a>
    </div>

    {{-- Messages --}}
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Statistiques --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-red-50 border border-red-200 p-4 rounded-lg">
            <p class="text-sm text-red-600 font-medium">Critiques</p>
            <p class="text-2xl font-bold text-red-700">{{ $alerts->where('niveau.value', 'critique')->count() }}</p>
        </div>
        <div class="bg-orange-50 border border-orange-200 p-4 rounded-lg">
            <p class="text-sm text-orange-600 font-medium">Élevées</p>
            <p class="text-2xl font-bold text-orange-700">{{ $alerts->where('niveau.value', 'eleve')->count() }}</p>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
            <p class="text-sm text-yellow-600 font-medium">Moyennes</p>
            <p class="text-2xl font-bold text-yellow-700">{{ $alerts->where('niveau.value', 'moyen')->count() }}</p>
        </div>
        <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
            <p class="text-sm text-blue-600 font-medium">Faibles</p>
            <p class="text-2xl font-bold text-blue-700">{{ $alerts->where('niveau.value', 'faible')->count() }}</p>
        </div>
    </div>

    {{-- Liste des alertes --}}
    <div class="space-y-4">
        @forelse($alerts as $alert)
            <div class="bg-white rounded-lg shadow-sm border-l-4 p-6
                @switch($alert->niveau->value)
                    @case('critique') border-red-500 @break
                    @case('eleve') border-orange-500 @break
                    @case('moyen') border-yellow-500 @break
                    @default border-blue-500
                @endswitch">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                @switch($alert->niveau->value)
                                    @case('critique') bg-red-100 text-red-800 @break
                                    @case('eleve') bg-orange-100 text-orange-800 @break
                                    @case('moyen') bg-yellow-100 text-yellow-800 @break
                                    @default bg-blue-100 text-blue-800
                                @endswitch">
                                {{ $alert->niveau->label() }}
                            </span>
                            @if($alert->publiee)
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-200 text-gray-800">
                                    Publiée
                                </span>
                            @endif
                            <span class="text-sm text-gray-500">
                                {{ $alert->created_at->diffForHumans() }}
                            </span>
                        </div>
                        
                        <p class="text-gray-900 mb-2">{{ $alert->message }}</p>
                        
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">Zone:</span> {{ $alert->sample->zone->nom }}
                            <span class="mx-2">•</span>
                            <span class="font-medium">Échantillon:</span> {{ $alert->sample->date_prelevement->format('d/m/Y H:i') }}
                        </div>
                    </div>

                    <div class="flex items-center gap-2 ml-4">
                        <a href="{{ route('admin.quality.alerts.show', $alert) }}" 
                           class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                            Voir
                        </a>
                        @if(!$alert->date_resolution)
                            <form method="POST" action="{{ route('admin.quality.alerts.resolve', $alert) }}" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                                    Résoudre
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-sm border p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-gray-600 text-lg">Aucune alerte active</p>
                <p class="text-gray-500 text-sm mt-1">Toutes les alertes sont résolues</p>
            </div>
        @endforelse
    </div>

    @if ($alerts->hasPages())
        <div class="mt-6">{{ $alerts->links() }}</div>
    @endif
</div>
