<x-layouts.admin>
    <x-slot name="title">Créer un incident</x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Créer un incident</h1>
                <p class="mt-1 text-sm text-gray-600">Signaler un nouvel incident</p>
            </div>
            <a href="{{ route('admin.incidents.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour à la liste
            </a>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <form method="POST" action="{{ route('admin.incidents.store') }}">
                @csrf

                @include('incident.admin._form', [
                    'incident' => null,
                    'infrastructures' => $infrastructures,
                    'techniciens' => $techniciens,
                    'citoyens' => $citoyens,
                    'statuts' => $statuts,
                    'urgences' => $urgences,
                    'types' => $types,
                ])

                <!-- Boutons -->
                <div class="flex gap-3 pt-6 border-t border-gray-200 mt-6">
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Créer l'incident
                    </button>
                    <a href="{{ route('admin.incidents.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition duration-150">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>
