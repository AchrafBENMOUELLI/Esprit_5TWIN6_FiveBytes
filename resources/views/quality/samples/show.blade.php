@props(['sample'])

<div class="max-w-6xl mx-auto p-6">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.quality.samples.index') }}" 
                   class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Détails de l'analyse</h2>
                    <p class="text-gray-600 text-sm mt-1">
                        Échantillon #{{ $sample->id }} - {{ $sample->date_prelevement->format('d/m/Y à H:i') }}
                    </p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.quality.samples.edit', $sample) }}" 
                   class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Modifier
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Informations principales --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Résultat global --}}
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Résultat global</h3>
                        <p class="text-sm text-gray-600">Conformité de l'échantillon</p>
                    </div>
                    <div>
                        @if($sample->resultat_global)
                            <span class="px-6 py-3 inline-flex text-lg leading-5 font-bold rounded-lg
                                {{ $sample->resultat_global->value === 'conforme' 
                                    ? 'bg-green-100 text-green-800 border-2 border-green-300' 
                                    : 'bg-red-100 text-red-800 border-2 border-red-300' }}">
                                {{ $sample->resultat_global->label() }}
                            </span>
                        @else
                            <span class="text-gray-400">Non défini</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Paramètres analysés --}}
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Paramètres analysés</h3>
                
                <div class="space-y-3">
                    @forelse($sample->parameters as $parameter)
                        <div class="p-4 border rounded-lg {{ $parameter->depasse_seuil ? 'bg-red-50 border-red-200' : 'bg-gray-50 border-gray-200' }}">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        @if($parameter->depasse_seuil)
                                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @endif
                                        <span class="font-semibold text-gray-800">
                                            {{ $parameter->threshold->parametre->label() }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-1 ml-7">
                                        Seuils acceptables: 
                                        @if($parameter->threshold->valeur_min)
                                            {{ $parameter->threshold->valeur_min }}
                                        @endif
                                        @if($parameter->threshold->valeur_min && $parameter->threshold->valeur_max)
                                            -
                                        @endif
                                        @if($parameter->threshold->valeur_max)
                                            {{ $parameter->threshold->valeur_max }}
                                        @endif
                                        {{ $parameter->threshold->unite }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="text-2xl font-bold {{ $parameter->depasse_seuil ? 'text-red-600' : 'text-gray-800' }}">
                                        {{ $parameter->valeur }}
                                    </span>
                                    <span class="text-sm text-gray-600 ml-1">{{ $parameter->threshold->unite }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">Aucun paramètre analysé</p>
                    @endforelse
                </div>
            </div>

            {{-- Alertes associées --}}
            @if($sample->alerts->isNotEmpty())
                <div class="bg-white rounded-lg shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Alertes générées</h3>
                    
                    <div class="space-y-3">
                        @foreach($sample->alerts as $alert)
                            <div class="p-4 border-l-4 rounded
                                @switch($alert->niveau->value)
                                    @case('critique') bg-red-50 border-red-500 @break
                                    @case('eleve') bg-orange-50 border-orange-500 @break
                                    @case('moyen') bg-yellow-50 border-yellow-500 @break
                                    @default bg-blue-50 border-blue-500
                                @endswitch">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="px-2 py-1 text-xs font-semibold rounded
                                                @switch($alert->niveau->value)
                                                    @case('critique') bg-red-200 text-red-800 @break
                                                    @case('eleve') bg-orange-200 text-orange-800 @break
                                                    @case('moyen') bg-yellow-200 text-yellow-800 @break
                                                    @default bg-blue-200 text-blue-800
                                                @endswitch">
                                                {{ $alert->niveau->label() }}
                                            </span>
                                            @if($alert->publiee)
                                                <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-200 text-gray-800">
                                                    Publiée
                                                </span>
                                            @endif
                                            @if($alert->date_resolution)
                                                <span class="px-2 py-1 text-xs font-semibold rounded bg-green-200 text-green-800">
                                                    Résolue
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-800">{{ $alert->message }}</p>
                                        @if($alert->date_resolution)
                                            <p class="text-xs text-gray-600 mt-1">
                                                Résolue le {{ $alert->date_resolution->format('d/m/Y à H:i') }}
                                            </p>
                                        @endif
                                    </div>
                                    <a href="{{ route('admin.quality.alerts.show', $alert) }}" 
                                       class="text-blue-600 hover:text-blue-800 ml-4">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar avec métadonnées --}}
        <div class="space-y-6">
            {{-- Informations du prélèvement --}}
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informations</h3>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Zone</p>
                        <p class="text-sm font-medium text-gray-800">{{ $sample->zone->nom }}</p>
                    </div>

                    @if($sample->infrastructure)
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Infrastructure</p>
                            <p class="text-sm font-medium text-gray-800">{{ $sample->infrastructure->nom }}</p>
                        </div>
                    @endif

                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Prélevé par</p>
                        <p class="text-sm font-medium text-gray-800">{{ $sample->preleveur->name }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Date de prélèvement</p>
                        <p class="text-sm font-medium text-gray-800">
                            {{ $sample->date_prelevement->format('d/m/Y à H:i') }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ $sample->date_prelevement->diffForHumans() }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Enregistré le</p>
                        <p class="text-sm text-gray-600">
                            {{ $sample->created_at->format('d/m/Y à H:i') }}
                        </p>
                    </div>

                    @if($sample->updated_at != $sample->created_at)
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Dernière modification</p>
                            <p class="text-sm text-gray-600">
                                {{ $sample->updated_at->format('d/m/Y à H:i') }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Résumé IA si disponible --}}
            @if($sample->resume_ia)
                <div class="bg-blue-50 rounded-lg border border-blue-200 p-6">
                    <div class="flex items-start gap-2 mb-2">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="font-semibold text-blue-900">Résumé IA</h3>
                    </div>
                    <p class="text-sm text-blue-800">{{ $sample->resume_ia }}</p>
                </div>
            @endif

            {{-- Actions --}}
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Actions</h3>
                
                <div class="space-y-2">
                    <a href="{{ route('admin.quality.samples.edit', $sample) }}" 
                       class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 inline-flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Modifier
                    </a>

                    <form method="POST" 
                          action="{{ route('admin.quality.samples.destroy', $sample) }}"
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet échantillon ? Cette action est irréversible.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 inline-flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
