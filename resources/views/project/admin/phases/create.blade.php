@extends('layouts.admin')

@section('title', 'Nouvelle Phase')

@section('content')
<x-project.layouts.admin
    title="Nouvelle Phase"
    :breadcrumbs="[
        ['label' => 'Tableau de bord', 'url' => route('dashboard')],
        ['label' => 'Projets', 'url' => route('admin.projects.index')],
        ['label' => $project->titre, 'url' => route('admin.projects.show', $project)],
        ['label' => 'Nouvelle Phase', 'url' => null]
    ]">

<div class="container-fluid py-4">
    {{-- En-tête avec contexte du projet --}}
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Projets</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.projects.show', $project) }}">{{ $project->titre }}</a></li>
                <li class="breadcrumb-item active">Nouvelle Phase</li>
            </ol>
        </nav>
        <h1 class="h2 mb-3">Ajouter une Phase au Projet</h1>
        
        {{-- Contexte du projet --}}
        <div class="card border-primary bg-light mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="mb-2">
                            <i class="fas fa-project-diagram text-primary me-2"></i>
                            {{ $project->titre }}
                        </h5>
                        <div class="d-flex gap-3 text-muted small">
                            <span>
                                <i class="fas fa-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($project->date_debut)->format('d/m/Y') }} 
                                → 
                                {{ \Carbon\Carbon::parse($project->date_fin_prevue)->format('d/m/Y') }}
                            </span>
                            <span>
                                <i class="fas fa-euro-sign me-1"></i>
                                Budget: {{ number_format($project->budget_prevu, 0, ',', ' ') }} €
                            </span>
                            <span class="badge bg-{{ $project->statut === 'en_cours' ? 'success' : 'secondary' }}">
                                {{ ucfirst(str_replace('_', ' ', $project->statut)) }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="text-muted small mb-1">Avancement global</div>
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar bg-primary" 
                                 role="progressbar" 
                                 style="width: {{ $project->avancement_pourcentage }}%">
                                {{ $project->avancement_pourcentage }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.projects.phase.store', $project) }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <input type="hidden" name="project_id" value="{{ $project->id }}">

        <div class="row">
            {{-- Colonne gauche --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Informations de la Phase
                        </h5>
                    </div>
                    <div class="card-body">
                        {{-- Nom --}}
                        <div class="mb-3">
                            <label for="nom" class="form-label">
                                Nom de la phase <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nom') is-invalid @enderror" 
                                   id="nom" 
                                   name="nom" 
                                   value="{{ old('nom') }}"
                                   placeholder="Ex: Phase 1 - Terrassement"
                                   required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-lightbulb me-1"></i>
                                Suggestions: Terrassement, Fondations, Gros œuvre, Plomberie, Électricité, Finitions
                            </div>
                        </div>

                        {{-- Contractant --}}
                        <div class="mb-3">
                            <label for="contractor_id" class="form-label">
                                Contractant / Prestataire <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('contractor_id') is-invalid @enderror" 
                                    id="contractor_id" 
                                    name="contractor_id"
                                    required>
                                <option value="">Sélectionner un contractant</option>
                                @foreach(\App\Models\Project\Contractor::all() as $contractor)
                                    <option value="{{ $contractor->id }}" 
                                            data-specialite="{{ $contractor->specialite }}"
                                            {{ old('contractor_id') == $contractor->id ? 'selected' : '' }}>
                                        {{ $contractor->nom }} - {{ ucfirst($contractor->specialite) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('contractor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text" id="contractor-info"></div>
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
                                       value="{{ old('date_debut', $project->date_debut) }}"
                                       min="{{ $project->date_debut }}"
                                       max="{{ $project->date_fin_prevue }}"
                                       required>
                                @error('date_debut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="date_fin" class="form-label">
                                    Date de fin <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('date_fin') is-invalid @enderror" 
                                       id="date_fin" 
                                       name="date_fin" 
                                       value="{{ old('date_fin') }}"
                                       min="{{ $project->date_debut }}"
                                       max="{{ $project->date_fin_prevue }}"
                                       required>
                                @error('date_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Période du projet:</strong>
                            {{ \Carbon\Carbon::parse($project->date_debut)->format('d/m/Y') }}
                            au
                            {{ \Carbon\Carbon::parse($project->date_fin_prevue)->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Colonne droite --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-euro-sign me-2"></i>
                            Coût et Avancement
                        </h5>
                    </div>
                    <div class="card-body">
                        {{-- Coût --}}
                        <div class="mb-3">
                            <label for="cout" class="form-label">
                                Coût de la phase (€) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number" 
                                       class="form-control @error('cout') is-invalid @enderror" 
                                       id="cout" 
                                       name="cout" 
                                       value="{{ old('cout') }}"
                                       step="0.01"
                                       min="0"
                                       required>
                                <span class="input-group-text">€</span>
                                @error('cout')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text" id="budget-info">
                                <i class="fas fa-calculator me-1"></i>
                                Budget projet: {{ number_format($project->budget_prevu, 0, ',', ' ') }} €
                                @if($project->projectPhases->count() > 0)
                                    | Déjà alloué: {{ number_format($project->projectPhases->sum('cout'), 0, ',', ' ') }} €
                                @endif
                            </div>
                        </div>

                        {{-- Avancement --}}
                        <div class="mb-3">
                            <label for="avancement" class="form-label">
                                Avancement initial (%)
                            </label>
                            <input type="range" 
                                   class="form-range" 
                                   id="avancement" 
                                   name="avancement" 
                                   min="0" 
                                   max="100" 
                                   step="5"
                                   value="{{ old('avancement', 0) }}">
                            <div class="d-flex justify-content-between">
                                <span class="small text-muted">0%</span>
                                <span class="badge bg-primary" id="avancement-value">0%</span>
                                <span class="small text-muted">100%</span>
                            </div>
                            @error('avancement')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Vous pourrez modifier l'avancement ultérieurement
                            </div>
                        </div>

                        {{-- Résumé des phases existantes --}}
                        @if($project->projectPhases->count() > 0)
                            <div class="alert alert-warning">
                                <h6 class="alert-heading">
                                    <i class="fas fa-list me-2"></i>
                                    Phases existantes ({{ $project->projectPhases->count() }})
                                </h6>
                                <ul class="mb-0 ps-3 small">
                                    @foreach($project->projectPhases->take(3) as $phase)
                                        <li>{{ $phase->nom }} - {{ number_format($phase->cout, 0, ',', ' ') }} € ({{ $phase->avancement }}%)</li>
                                    @endforeach
                                    @if($project->projectPhases->count() > 3)
                                        <li class="text-muted">... et {{ $project->projectPhases->count() - 3 }} autre(s)</li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Retour au projet
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check me-2"></i>
                        Créer la phase
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
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

    // Mise à jour de l'affichage de l'avancement
    const avancementInput = document.getElementById('avancement');
    const avancementValue = document.getElementById('avancement-value');
    
    avancementInput.addEventListener('input', function() {
        avancementValue.textContent = this.value + '%';
    });

    // Afficher les infos du contractant sélectionné
    document.getElementById('contractor_id').addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        const info = document.getElementById('contractor-info');
        
        if (this.value) {
            const specialite = option.getAttribute('data-specialite');
            info.innerHTML = '<i class="fas fa-info-circle text-primary me-1"></i> Spécialité: <strong>' + specialite + '</strong>';
        } else {
            info.innerHTML = '';
        }
    });

    // Validation des dates
    document.getElementById('date_fin').addEventListener('change', function() {
        const dateDebut = document.getElementById('date_debut').value;
        const dateFin = this.value;
        
        if (dateDebut && dateFin && dateFin < dateDebut) {
            this.setCustomValidity('La date de fin doit être après la date de début');
        } else {
            this.setCustomValidity('');
        }
    });

    // Calcul de la durée
    function updateDuration() {
        const dateDebut = document.getElementById('date_debut').value;
        const dateFin = document.getElementById('date_fin').value;
        
        if (dateDebut && dateFin) {
            const debut = new Date(dateDebut);
            const fin = new Date(dateFin);
            const diffTime = Math.abs(fin - debut);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if (diffDays > 0) {
                const info = document.getElementById('budget-info');
                info.innerHTML += ' | <strong class="text-success">Durée: ' + diffDays + ' jour(s)</strong>';
            }
        }
    }

    document.getElementById('date_debut').addEventListener('change', updateDuration);
    document.getElementById('date_fin').addEventListener('change', updateDuration);
</script>

</x-project.layouts.admin>
@endsection
