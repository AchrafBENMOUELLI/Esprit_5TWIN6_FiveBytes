@php
use App\Models\Infrastructure\Zone;
use App\Models\Infrastructure\Infrastructure;
use App\Models\User;
@endphp

<x-project.layouts.admin 
    title="Modifier Projet"
    :breadcrumbs="[
        ['label' => 'Tableau de bord', 'url' => route('admin.dashboard')],
        ['label' => 'Projets', 'url' => route('admin.projects.index')],
        ['label' => $project->titre, 'url' => route('admin.projects.show', $project)],
        ['label' => 'Modifier', 'url' => null]
    ]">

    <div class="aq-card">
        <div class="aq-card-header">
            <div>
                <h2 class="aq-card-title">Modifier le Projet</h2>
                <p class="aq-card-subtitle">{{ $project->titre }}</p>
            </div>
        </div>

        <form action="{{ route('admin.projects.update', $project) }}" method="POST" class="aq-form">
            @csrf
            @method('PUT')

            <div class="aq-grid-2">
                {{-- Colonne gauche --}}
                <div>
                    <div class="aq-form-group">
                        <label for="titre" class="aq-form-label">
                            Titre du projet <span class="aq-required">*</span>
                        </label>
                        <input type="text" 
                               id="titre" 
                               name="titre" 
                               class="aq-form-control @error('titre') aq-form-error @enderror" 
                               value="{{ old('titre', $project->titre) }}"
                               required>
                        @error('titre')
                            <span class="aq-error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="aq-form-group">
                        <label for="type" class="aq-form-label">
                            Type de projet <span class="aq-required">*</span>
                        </label>
                        <select id="type" 
                                name="type" 
                                class="aq-form-control @error('type') aq-form-error @enderror"
                                required>
                            <option value="">Sélectionner un type</option>
                            <option value="réparation" {{ old('type', $project->type) === 'réparation' ? 'selected' : '' }}>Réparation</option>
                            <option value="modernisation" {{ old('type', $project->type) === 'modernisation' ? 'selected' : '' }}>Modernisation</option>
                            <option value="extension" {{ old('type', $project->type) === 'extension' ? 'selected' : '' }}>Extension</option>
                            <option value="construction" {{ old('type', $project->type) === 'construction' ? 'selected' : '' }}>Construction</option>
                        </select>
                        @error('type')
                            <span class="aq-error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="aq-form-group">
                        <label for="description" class="aq-form-label">
                            Description <span class="aq-required">*</span>
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  class="aq-form-control @error('description') aq-form-error @enderror" 
                                  rows="5"
                                  required>{{ old('description', $project->description) }}</textarea>
                        @error('description')
                            <span class="aq-error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="aq-form-group">
                        <label for="budget_prevu" class="aq-form-label">
                            Budget prévu (€) <span class="aq-required">*</span>
                        </label>
                        <input type="number" 
                               id="budget_prevu" 
                               name="budget_prevu" 
                               class="aq-form-control @error('budget_prevu') aq-form-error @enderror" 
                               value="{{ old('budget_prevu', $project->budget_prevu) }}"
                               step="0.01"
                               min="0"
                               required>
                        @error('budget_prevu')
                            <span class="aq-error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="aq-form-row">
                        <div class="aq-form-group">
                            <label for="date_debut" class="aq-form-label">
                                Date de début <span class="aq-required">*</span>
                            </label>
                            <input type="date" 
                                   id="date_debut" 
                                   name="date_debut" 
                                   class="aq-form-control @error('date_debut') aq-form-error @enderror" 
                                   value="{{ old('date_debut', $project->date_debut) }}"
                                   required>
                            @error('date_debut')
                                <span class="aq-error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="aq-form-group">
                            <label for="date_fin_prevue" class="aq-form-label">
                                Date de fin prévue <span class="aq-required">*</span>
                            </label>
                            <input type="date" 
                                   id="date_fin_prevue" 
                                   name="date_fin_prevue" 
                                   class="aq-form-control @error('date_fin_prevue') aq-form-error @enderror" 
                                   value="{{ old('date_fin_prevue', $project->date_fin_prevue) }}"
                                   required>
                            @error('date_fin_prevue')
                                <span class="aq-error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Colonne droite --}}
                <div>
                    <div class="aq-form-group">
                        <label for="zone_id" class="aq-form-label">
                            Zone <span class="aq-required">*</span>
                        </label>
                        <select id="zone_id" 
                                name="zone_id" 
                                class="aq-form-control @error('zone_id') aq-form-error @enderror"
                                required>
                            <option value="">Sélectionner une zone</option>
                            @foreach(Zone::all() as $zone)
                                <option value="{{ $zone->id }}" {{ old('zone_id', $project->zone_id) == $zone->id ? 'selected' : '' }}>
                                    {{ $zone->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('zone_id')
                            <span class="aq-error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="aq-form-group">
                        <label for="infrastructure_id" class="aq-form-label">
                            Infrastructure <span class="aq-required">*</span>
                        </label>
                        <select id="infrastructure_id" 
                                name="infrastructure_id" 
                                class="aq-form-control @error('infrastructure_id') aq-form-error @enderror"
                                required>
                            <option value="">Sélectionner une infrastructure</option>
                            @foreach(Infrastructure::all() as $infrastructure)
                                <option value="{{ $infrastructure->id }}" 
                                        data-zone="{{ $infrastructure->zone_id }}"
                                        {{ old('infrastructure_id', $project->infrastructure_id) == $infrastructure->id ? 'selected' : '' }}>
                                    {{ $infrastructure->nom }} ({{ $infrastructure->type }})
                                </option>
                            @endforeach
                        </select>
                        @error('infrastructure_id')
                            <span class="aq-error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="aq-form-group">
                        <label for="responsable_id" class="aq-form-label">
                            Responsable du projet <span class="aq-required">*</span>
                        </label>
                        <select id="responsable_id" 
                                name="responsable_id" 
                                class="aq-form-control @error('responsable_id') aq-form-error @enderror"
                                required>
                            <option value="">Sélectionner un responsable</option>
                            @foreach(User::whereIn('role', ['admin', 'gestionnaire'])->get() as $user)
                                <option value="{{ $user->id }}" {{ old('responsable_id', $project->responsable_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ ucfirst($user->role) }})
                                </option>
                            @endforeach
                        </select>
                        @error('responsable_id')
                            <span class="aq-error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="aq-form-group">
                        <label for="statut" class="aq-form-label">
                            Statut <span class="aq-required">*</span>
                        </label>
                        <select id="statut" 
                                name="statut" 
                                class="aq-form-control @error('statut') aq-form-error @enderror"
                                required>
                            <option value="planifié" {{ old('statut', $project->statut) === 'planifié' ? 'selected' : '' }}>Planifié</option>
                            <option value="en_cours" {{ old('statut', $project->statut) === 'en_cours' ? 'selected' : '' }}>En cours</option>
                            <option value="terminé" {{ old('statut', $project->statut) === 'terminé' ? 'selected' : '' }}>Terminé</option>
                            <option value="suspendu" {{ old('statut', $project->statut) === 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                            <option value="annulé" {{ old('statut', $project->statut) === 'annulé' ? 'selected' : '' }}>Annulé</option>
                        </select>
                        @error('statut')
                            <span class="aq-error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="aq-form-group">
                        <label for="avancement_pourcentage" class="aq-form-label">
                            Avancement (%)
                        </label>
                        <input type="number" 
                               id="avancement_pourcentage" 
                               name="avancement_pourcentage" 
                               class="aq-form-control @error('avancement_pourcentage') aq-form-error @enderror" 
                               value="{{ old('avancement_pourcentage', $project->avancement_pourcentage) }}"
                               min="0"
                               max="100">
                        @error('avancement_pourcentage')
                            <span class="aq-error-message">{{ $message }}</span>
                        @enderror
                        <div class="aq-progress" style="margin-top: 0.5rem;">
                            <div class="aq-progress-bar" style="width: {{ $project->avancement_pourcentage }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="aq-form-actions">
                <button type="submit" class="aq-btn aq-btn-primary">
                    <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Enregistrer les modifications
                </button>
                <a href="{{ route('admin.projects.show', $project) }}" class="aq-btn aq-btn-outline">
                    Annuler
                </a>
                <a href="{{ route('admin.projects.index') }}" class="aq-btn aq-btn-outline">
                    Retour à la liste
                </a>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        // Filtrer les infrastructures par zone
        document.getElementById('zone_id').addEventListener('change', function() {
            const zoneId = this.value;
            const infrastructureSelect = document.getElementById('infrastructure_id');
            const options = infrastructureSelect.querySelectorAll('option');
            
            options.forEach(option => {
                if (option.value === '') {
                    option.style.display = 'block';
                    return;
                }
                
                const optionZone = option.getAttribute('data-zone');
                if (!zoneId || optionZone === zoneId) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
            
            const selectedOption = infrastructureSelect.options[infrastructureSelect.selectedIndex];
            if (selectedOption && selectedOption.getAttribute('data-zone') !== zoneId) {
                infrastructureSelect.value = '';
            }
        });
        
        if (document.getElementById('zone_id').value) {
            document.getElementById('zone_id').dispatchEvent(new Event('change'));
        }

        // Mettre à jour la barre de progression en temps réel
        document.getElementById('avancement_pourcentage').addEventListener('input', function() {
            const progress = this.value;
            const progressBar = document.querySelector('.aq-progress-bar');
            progressBar.style.width = progress + '%';
        });
    </script>
    @endpush

</x-project.layouts.admin>
