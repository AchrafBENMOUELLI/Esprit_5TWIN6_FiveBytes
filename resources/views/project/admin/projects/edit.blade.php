<x-project.layouts.admin
    title="Modifier le Projet"
    :breadcrumbs="[
        ['label' => 'Tableau de bord', 'url' => route('dashboard')],
        ['label' => 'Projets', 'url' => route('admin.projects.index')],
        ['label' => 'Modifier', 'url' => null]
    ]">

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-4">
                    <div class="d-flex align-items-center">
                        <div class="rounded-2 bg-primary bg-opacity-10 p-3 me-3">
                            <i class="fas fa-edit fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-1">Modifier le Projet</h3>
                            <p class="text-muted mb-0">{{ $project->titre }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.projects.update', $project) }}" method="POST" class="row g-4">
                        @csrf
                        @method('PUT')

                        {{-- Informations Générales --}}
                        <div class="col-12">
                            <h5 class="fw-semibold mb-3 pb-2 border-bottom">
                                <i class="fas fa-info-circle me-2 text-primary"></i>Informations Générales
                            </h5>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-medium">
                                Titre du projet <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('titre') is-invalid @enderror" 
                                   id="titre" 
                                   name="titre" 
                                   value="{{ old('titre', $project->titre) }}"
                                   placeholder="Ex: Rénovation Station de Pompage Nord"
                                   required>
                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-medium">
                                Type de projet <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('type') is-invalid @enderror" 
                                    id="type" 
                                    name="type"
                                    required>
                                <option value="">Sélectionner un type</option>
                                <option value="réparation" {{ old('type', $project->type) === 'réparation' ? 'selected' : '' }}>Réparation</option>
                                <option value="modernisation" {{ old('type', $project->type) === 'modernisation' ? 'selected' : '' }}>Modernisation</option>
                                <option value="extension" {{ old('type', $project->type) === 'extension' ? 'selected' : '' }}>Extension</option>
                                <option value="construction" {{ old('type', $project->type) === 'construction' ? 'selected' : '' }}>Construction</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-medium">
                                Description <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4"
                                      placeholder="Décrivez le projet en détail..."
                                      required>{{ old('description', $project->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-medium">
                                Budget prévu (€) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">€</span>
                                <input type="number" 
                                       class="form-control @error('budget_prevu') is-invalid @enderror" 
                                       id="budget_prevu" 
                                       name="budget_prevu" 
                                       value="{{ old('budget_prevu', $project->budget_prevu) }}"
                                       step="0.01"
                                       min="0"
                                       placeholder="0.00"
                                       required>
                                @error('budget_prevu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-medium">
                                Date de début <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   class="form-control @error('date_debut') is-invalid @enderror" 
                                   id="date_debut" 
                                   name="date_debut" 
                                   value="{{ old('date_debut', $project->date_debut) }}"
                                   required>
                            @error('date_debut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-medium">
                                Date de fin prévue <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   class="form-control @error('date_fin_prevue') is-invalid @enderror" 
                                   id="date_fin_prevue" 
                                   name="date_fin_prevue" 
                                   value="{{ old('date_fin_prevue', $project->date_fin_prevue) }}"
                                   required>
                            @error('date_fin_prevue')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Configuration --}}
                        <div class="col-12 mt-4">
                            <h5 class="fw-semibold mb-3 pb-2 border-bottom">
                                <i class="fas fa-cog me-2 text-primary"></i>Configuration
                            </h5>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-medium">
                                Zone <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('zone_id') is-invalid @enderror" 
                                    id="zone_id" 
                                    name="zone_id"
                                    required>
                                <option value="">Sélectionner une zone</option>
                                @foreach($zones as $zone)
                                    <option value="{{ $zone->id }}" {{ old('zone_id', $project->zone_id) == $zone->id ? 'selected' : '' }}>
                                        {{ $zone->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('zone_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-medium">
                                Infrastructure <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('infrastructure_id') is-invalid @enderror" 
                                    id="infrastructure_id" 
                                    name="infrastructure_id"
                                    required>
                                <option value="">Sélectionner une infrastructure</option>
                                @foreach($infrastructures as $infrastructure)
                                    <option value="{{ $infrastructure->id }}" 
                                            data-zone="{{ $infrastructure->zone_id }}"
                                            {{ old('infrastructure_id', $project->infrastructure_id) == $infrastructure->id ? 'selected' : '' }}>
                                        {{ $infrastructure->nom }} ({{ $infrastructure->type }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Les infrastructures sont filtrées par zone</small>
                            @error('infrastructure_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-medium">
                                Responsable du projet <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('responsable_id') is-invalid @enderror" 
                                    id="responsable_id" 
                                    name="responsable_id"
                                    required>
                                <option value="">Sélectionner un responsable</option>
                                @foreach($gestionnaires as $gestionnaire)
                                    <option value="{{ $gestionnaire->id }}" {{ old('responsable_id', $project->responsable_id) == $gestionnaire->id ? 'selected' : '' }}>
                                        {{ $gestionnaire->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('responsable_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-medium">
                                Statut <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('statut') is-invalid @enderror" 
                                    id="statut" 
                                    name="statut"
                                    required>
                                <option value="planifié" {{ old('statut', $project->statut) === 'planifié' ? 'selected' : '' }}>Planifié</option>
                                <option value="en_cours" {{ old('statut', $project->statut) === 'en_cours' ? 'selected' : '' }}>En cours</option>
                                <option value="terminé" {{ old('statut', $project->statut) === 'terminé' ? 'selected' : '' }}>Terminé</option>
                                <option value="suspendu" {{ old('statut', $project->statut) === 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                                <option value="annulé" {{ old('statut', $project->statut) === 'annulé' ? 'selected' : '' }}>Annulé</option>
                            </select>
                            @error('statut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-medium">
                                Avancement (%)
                            </label>
                            <input type="number" 
                                   class="form-control @error('avancement_pourcentage') is-invalid @enderror" 
                                   id="avancement_pourcentage" 
                                   name="avancement_pourcentage" 
                                   value="{{ old('avancement_pourcentage', $project->avancement_pourcentage) }}"
                                   min="0"
                                   max="100"
                                   placeholder="0">
                            @error('avancement_pourcentage')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Actions --}}
                        <div class="col-12 mt-4 pt-4 border-top">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i>Retour
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    <i class="fas fa-save me-2"></i>Enregistrer les modifications
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
</script>

</x-project.layouts.admin>
