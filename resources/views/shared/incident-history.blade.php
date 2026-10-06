@props(['incident', 'simplified' => false])

@php
    // Charger l'historique avec le modificateur pour éviter N+1
    $history = $incident->statusHistory()->with('modificateur')->orderBy('date_changement', 'asc')->get();
@endphp

<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">
        Historique des changements de statut
    </h2>

    @if($history->isEmpty())
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="mt-2 text-sm text-gray-500">Aucun historique disponible</p>
        </div>
    @else
        <!-- Timeline verticale -->
        <div class="flow-root">
            <ul class="-mb-8">
                @foreach($history as $index => $entry)
                    <li>
                        <div class="relative pb-8">
                            <!-- Ligne de connexion (sauf pour le dernier élément) -->
                            @if(!$loop->last)
                                <span class="absolute left-5 top-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                            @endif

                            <div class="relative flex items-start space-x-3">
                                <!-- Icône -->
                                <div>
                                    <div class="relative px-1">
                                        <div class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white
                                            {{ $entry->nouveau_statut ? $entry->nouveau_statut->color() : 'bg-gray-100' }}">
                                            @if($entry->ancien_statut === null)
                                                <!-- Icône de création -->
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                                </svg>
                                            @else
                                                <!-- Icône de changement -->
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                                                </svg>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Contenu -->
                                <div class="min-w-0 flex-1">
                                    <div>
                                        <!-- Changement de statut -->
                                        <div class="text-sm">
                                            @if($entry->ancien_statut === null)
                                                <span class="font-medium text-gray-900">Incident créé</span>
                                                <span class="text-gray-500">avec le statut</span>
                                                <span class="ml-1 px-2 py-1 text-xs font-medium rounded-full border {{ $entry->nouveau_statut->color() }}">
                                                    {{ $entry->nouveau_statut->label() }}
                                                </span>
                                            @else
                                                <span class="font-medium text-gray-900">Statut modifié</span>
                                                <div class="mt-1 flex items-center gap-2">
                                                    <span class="px-2 py-1 text-xs font-medium rounded-full border {{ $entry->ancien_statut->color() }}">
                                                        {{ $entry->ancien_statut->label() }}
                                                    </span>
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                                    </svg>
                                                    <span class="px-2 py-1 text-xs font-medium rounded-full border {{ $entry->nouveau_statut->color() }}">
                                                        {{ $entry->nouveau_statut->label() }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Informations supplémentaires -->
                                        <div class="mt-2 text-sm text-gray-500">
                                            <!-- Utilisateur qui a modifié (sauf en mode simplifié pour le front citoyen) -->
                                            @if(!$simplified && $entry->modificateur)
                                                <div class="flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                    <span>par <span class="font-medium text-gray-700">{{ $entry->modificateur->name }}</span></span>
                                                </div>
                                            @endif

                                            <!-- Date -->
                                            <div class="flex items-center gap-1 {{ !$simplified && $entry->modificateur ? 'mt-1' : '' }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <time datetime="{{ $entry->date_changement->toIso8601String() }}">
                                                    {{ $entry->date_changement->format('d/m/Y à H:i') }}
                                                    <span class="text-gray-400">({{ $entry->date_changement->diffForHumans() }})</span>
                                                </time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
