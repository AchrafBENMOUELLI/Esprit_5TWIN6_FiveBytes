@props(['thresholds'])

<div class="max-w-7xl mx-auto p-6">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Seuils de qualité</h2>
            <p class="text-gray-600 text-sm mt-1">Gestion des seuils de conformité des paramètres</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.quality.samples.index') }}" 
               class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Retour aux échantillons
            </a>
            <a href="{{ route('admin.quality.thresholds.create') }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nouveau seuil
            </a>
        </div>
    </div>

    {{-- Messages --}}
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tableau --}}
    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paramètre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unité</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valeur Min</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valeur Max</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Niveau d'alerte</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($thresholds as $threshold)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-900">{{ $threshold->parametre->label() }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $threshold->unite }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $threshold->valeur_min ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $threshold->valeur_max ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                @switch($threshold->niveau_alerte->value)
                                    @case('critique') bg-red-100 text-red-800 @break
                                    @case('eleve') bg-orange-100 text-orange-800 @break
                                    @case('moyen') bg-yellow-100 text-yellow-800 @break
                                    @default bg-blue-100 text-blue-800
                                @endswitch">
                                {{ $threshold->niveau_alerte->label() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.quality.thresholds.show', $threshold) }}" 
                                   class="text-blue-600 hover:text-blue-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="{{ route('admin.quality.thresholds.edit', $threshold) }}" 
                                   class="text-indigo-600 hover:text-indigo-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form method="POST" 
                                      action="{{ route('admin.quality.thresholds.destroy', $threshold) }}"
                                      onsubmit="return confirm('Supprimer ce seuil ?')"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            Aucun seuil défini
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($thresholds->hasPages())
        <div class="mt-6">{{ $thresholds->links() }}</div>
    @endif
</div>
