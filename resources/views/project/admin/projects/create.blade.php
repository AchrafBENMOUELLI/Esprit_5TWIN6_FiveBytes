@extends('components.project.layouts.admin')

@section('title', 'Nouveau Projet')

@section('content')
<div class="container-fluid py-4">
    {{-- En-tête --}}
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Projets</a></li>
                <li class="breadcrumb-item active">Nouveau</li>
            </ol>
        </nav>
        <h1 class="h2 mb-1">Créer un Nouveau Projet</h1>
        <p class="text-muted">Remplissez les informations du projet de rénovation</p>
    </div>

    <form action="{{ route('admin.projects.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <div class="row">
            {{-- Colonne gauche --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i>Informations Générales</h5>
                    </div>
                    <div class="card-body">
                        {{-- Titre --}}
                        <div class="mb-3">
                            <label for="titre" class="form-label">
                                Titre du projet <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('titre') is-invalid @enderror" 
                                   id="titre" 
                                   name="titre" 
                                   value="{{ old('titre') }}"
                                   required>
                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Type --}}
                        <div class="mb-3">
                            <label for="type" class="form-label">
                                Type de projet <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('type') is-invalid @enderror" 
                                    id="type" 
                                    name="type"
                                    required>
                                <option value="">Sélectionner un type</option>
                                <option value="réparation" {{ old('type') === 'réparation' ? 'selected' : '' }}>Réparation</option>
                                <option value="modernisation" {{ old('type') === 'modernisation' ? 'selected' : '' }}>Modernisation</option>
                                <option value="extension" {{ old('type') === 'extension' ? 'selected' : '' }}>Extension</option>
                                <option value="construction" {{ old('type') === 'construction' ? 'selected' : '' }}>Construction</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="description" class="form-label">
                                Description <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="5"
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Budget --}}
                        <div class="mb-3">
                            <label for="budget_prevu" class="form-label">
                                Budget prévu (€) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number" 
                                       class="form-control @error('budget_prevu') is-invalid @enderror" 
                                       id="budget_prevu" 
                                       name="budget_prevu" 
                                       value="{{ old('budget_prevu') }}"
                                       step="0.01"
                                       min="0"
                                       required>
                                <span class="input-group-text">€</span>
                                @error('budget_prevu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Dates --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_debut" class="form-label">
                                    Date de début <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('date_debut') is-invalid @enderror" 
                                       id="date_debut" 
                                       name="date_debut" 
                                       value="{{ old('date_debut') }}"
                                       required>
                                @error('date_debut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="date_fin_prevue" class="form-label">
                                    Date de fin prévue <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('date_fin_prevue') is-invalid @enderror" 
                                       id="date_fin_prevue" 
                                       name="date_fin_prevue" 
                                       value="{{ old('date_fin_prevue') }}"
                                       required>
                                @error('date_fin_prevue')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Colonne droite --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0"><i class="fas fa-cog me-2"></i>Configuration</h5>
                    </div>
                    <div class="card-body">
                        {{-- Zone --}}
                        <div class="mb-3">
                            <label for="zone_id" class="form-label">
                                Zone <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('zone_id') is-invalid @enderror" 
                                    id="zone_id" 
                                    name="zone_id"
                                    required>
                                <option value="">Sélectionner une zone</option>
                                @foreach(\App\Models\Infrastructure\Zone::all() as $zone)
                                    <option value="{{ $zone->id }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>
                                        {{ $zone->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('zone_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Infrastructure --}}
                        <div class="mb-3">
                            <label for="infrastructure_id" class="form-label">
                                Infrastructure <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('infrastructure_id') is-invalid @enderror" 
                                    id="infrastructure_id" 
                                    name="infrastructure_id"
                                    required>
                                <option value="">Sélectionner une infrastructure</option>
                                @foreach(\App\Models\Infrastructure\Infrastructure::all() as $infrastructure)
                                    <option value="{{ $infrastructure->id }}" 
                                            data-zone="{{ $infrastructure->zone_id }}"
                                            {{ old('infrastructure_id') == $infrastructure->id ? 'selected' : '' }}>
                                        {{ $infrastructure->nom }} ({{ $infrastructure->type }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Les infrastructures sont filtrées par zone sélectionnée</div>
                            @error('infrastructure_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Responsable --}}
                        <div class="mb-3">
                            <label for="responsable_id" class="form-label">
                                Responsable du projet <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('responsable_id') is-invalid @enderror" 
                                    id="responsable_id" 
                                    name="responsable_id"
                                    required>
                                <option value="">Sélectionner un responsable</option>
                                @foreach(\App\Models\User::whereIn('role', ['admin', 'gestionnaire'])->get() as $user)
                                    <option value="{{ $user->id }}" {{ old('responsable_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ ucfirst($user->role) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('responsable_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Statut --}}
                        <div class="mb-3">
                            <label for="statut" class="form-label">
                                Statut <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('statut') is-invalid @enderror" 
                                    id="statut" 
                                    name="statut"
                                    required>
                                <option value="planifié" {{ old('statut', 'planifié') === 'planifié' ? 'selected' : '' }}>Planifié</option>
                                <option value="en_cours" {{ old('statut') === 'en_cours' ? 'selected' : '' }}>En cours</option>
                                <option value="terminé" {{ old('statut') === 'terminé' ? 'selected' : '' }}>Terminé</option>
                                <option value="suspendu" {{ old('statut') === 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                                <option value="annulé" {{ old('statut') === 'annulé' ? 'selected' : '' }}>Annulé</option>
                            </select>
                            @error('statut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Avancement --}}
                        <div class="mb-3">
                            <label for="avancement_pourcentage" class="form-label">
                                Avancement (%)
                            </label>
                            <input type="number" 
                                   class="form-control @error('avancement_pourcentage') is-invalid @enderror" 
                                   id="avancement_pourcentage" 
                                   name="avancement_pourcentage" 
                                   value="{{ old('avancement_pourcentage', 0) }}"
                                   min="0"
                                   max="100">
                            @error('avancement_pourcentage')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check me-2"></i>
                        Créer le projet
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

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
        
        // Réinitialiser la sélection si l'infrastructure n'est plus valide
        const selectedOption = infrastructureSelect.options[infrastructureSelect.selectedIndex];
        if (selectedOption && selectedOption.getAttribute('data-zone') !== zoneId) {
            infrastructureSelect.value = '';
        }
    });
    
    // Déclencher le filtrage au chargement si une zone est déjà sélectionnée
    if (document.getElementById('zone_id').value) {
        document.getElementById('zone_id').dispatchEvent(new Event('change'));
    }

    // Validation HTML5
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
@endpush
