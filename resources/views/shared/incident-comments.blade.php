@props(['incident', 'routePrefix' => 'admin'])

@php
    $user = auth()->user();
    $canCreateInternal = $user && in_array($user->role, [\App\Enums\UserRole::Gestionnaire, \App\Enums\UserRole::Admin]);
    $comments = $incident->visibleComments($user);
    $deleteRouteBase = route($routePrefix . '.incidents.comments.destroy', ['comment' => 'COMMENT_ID']);
@endphp

<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">
        Commentaires ({{ $comments->count() }})
    </h2>

    <!-- Liste des commentaires -->
    <div class="space-y-4 mb-6">
        @forelse($comments as $comment)
            <div class="border border-gray-200 rounded-lg p-4" 
                 x-data="{ 
                     showDeleteModal: false,
                     commentId: {{ $comment->id }},
                     commentAuthor: '{{ $comment->auteur->name }}'
                 }">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <!-- Avatar et nom de l'auteur -->
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div class="ml-2">
                                    <p class="font-medium text-gray-900">{{ $comment->auteur->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            <!-- Badge "Interne" -->
                            @if($comment->interne)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                    <svg class="inline w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    Interne
                                </span>
                            @endif
                        </div>

                        <!-- Contenu du commentaire -->
                        <div class="mt-2 text-gray-700 whitespace-pre-line">
                            {{ $comment->contenu }}
                        </div>
                    </div>

                    <!-- Bouton supprimer -->
                    @can('delete', $comment)
                        <button type="button"
                                @click="showDeleteModal = true"
                                class="ml-4 text-red-600 hover:text-red-800 transition-colors"
                                title="Supprimer le commentaire">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>

                        <!-- Modal de confirmation de suppression -->
                        <div x-show="showDeleteModal"
                             x-cloak
                             class="fixed inset-0 z-50 overflow-y-auto"
                             style="display: none;">
                            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                <div x-show="showDeleteModal"
                                     x-transition:enter="ease-out duration-300"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     x-transition:leave="ease-in duration-200"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0"
                                     @click="showDeleteModal = false"
                                     class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                                <div x-show="showDeleteModal"
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
                                                    Supprimer le commentaire
                                                </h3>
                                                <div class="mt-2">
                                                    <p class="text-sm text-gray-500">
                                                        Êtes-vous sûr de vouloir supprimer ce commentaire de <strong x-text="commentAuthor"></strong> ?
                                                        Cette action est irréversible.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                                        <form method="POST" x-bind:action="'{{ $deleteRouteBase }}'.replace('COMMENT_ID', commentId)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                Supprimer
                                            </button>
                                        </form>
                                        <button type="button" 
                                                @click="showDeleteModal = false"
                                                class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                                            Annuler
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <p class="mt-2 text-sm text-gray-500">Aucun commentaire pour le moment</p>
            </div>
        @endforelse
    </div>

    <!-- Formulaire d'ajout de commentaire -->
    @can('create', \App\Models\Incident\IncidentComment::class)
        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-md font-medium text-gray-900 mb-4">Ajouter un commentaire</h3>
            
            <form method="POST" action="{{ route($routePrefix . '.incidents.comments.store', $incident) }}">
                @csrf

                <div class="space-y-4">
                    <!-- Contenu du commentaire -->
                    <div>
                        <label for="contenu" class="block text-sm font-medium text-gray-700 mb-1">
                            Votre commentaire <span class="text-red-500">*</span>
                        </label>
                        <textarea name="contenu" 
                                  id="contenu" 
                                  rows="4" 
                                  required
                                  minlength="3"
                                  maxlength="2000"
                                  placeholder="Écrivez votre commentaire ici..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('contenu') border-red-500 @enderror">{{ old('contenu') }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">Minimum 3 caractères, maximum 2000 caractères</p>
                        @error('contenu')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Case à cocher "Commentaire interne" (visible seulement pour Gestionnaire et Admin) -->
                    @if($canCreateInternal)
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="interne" 
                                       name="interne" 
                                       type="checkbox" 
                                       value="1"
                                       {{ old('interne') ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            </div>
                            <div class="ml-2 text-sm">
                                <label for="interne" class="font-medium text-gray-700">
                                    Commentaire interne
                                </label>
                                <p class="text-xs text-gray-500">
                                    Les commentaires internes ne sont visibles que par les gestionnaires et administrateurs
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Bouton d'envoi -->
                    <div class="flex justify-end">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Publier le commentaire
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endcan
</div>
