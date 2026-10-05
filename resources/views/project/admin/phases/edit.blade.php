@extends('components.project.layouts.admin')

@section('title', 'Modifier Phase')

@section('content')
<div class="container-fluid py-4">
    {{-- En-tête avec contexte du projet --}}
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Projets</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.projects.show', $phase->project) }}">{{ $phase->project->titre }}</a></li>
                <li class="breadcrumb-item active">Modifier Phase</li>
            </ol>
        </nav>
        <h1 class="h2 mb-3">Modifier la Phase</h1>
        
        {{-- Contexte du projet --}}
        <div class="card border-primary bg-light mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="mb-2">
                            <i class="fas fa-project-diagram text-primary me-2"></i>
                            {{ $phase->project->titre }}
                        </h5>
                        <div class="d-flex gap-3 text-muted small">
                            <span>
                                <i class="fas fa-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($phase->project->date_debut)->format('d/m/Y') }} 
                                → 
                                {{ \Carbon\Carbon::parse($phase->project->date_fin_prevue)->format('d/m/Y') }}
                            </span>
                            <span>
                                <i class="fas fa-euro-sign me-1"></i>
                                Budget: {{ number_format($phase->project->budget_prevu, 0, ',', ' ') }} €
                            </span>
                            <span class="badge bg-{{ $phase->project->statut === 'en_cours' ? 'success' : 'secondary' }}">
                                {{ ucfirst(str_replace('_', ' ', $phase->project->statut)) }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="text-muted small mb-1">Avancement global</div>
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar bg-primary" 
                                 role="progressbar" 
                                 style="width: {{ $phase->project->avancement_pourcentage }}%">
                                {{ $phase->project->avancement_pourcentage }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.project-phases.update', $phase) }}" method="POST" class="needs-validation" novalidate>
        @csrf
        @method('PUT')

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
                                   value="{{ old('nom', $phase->nom) }}"
                                   placeholder="Ex: Phase 1 - Terrassement"
                                   required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                                            {{ old('contractor_id', $phase->contractor_id) == $contractor->id ? 'selected' : '' }}>
                                        {{ $contractor->nom }} - {{ ucfirst($contractor->specialite) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('contractor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text" id="contractor-info">
                                @if($phase->contractor)
                                    <i class="fas fa-info-circle text-primary me-1"></i>
                                    Spécialité: <strong>{{ ucfirst($phase->contractor->specialite) }}</strong>
                                @endif
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
                                       value="{{ old('date_debut', $phase->date_debut) }}"
                                       min="{{ $phase->project->date_debut }}"
                                       max="{{ $phase->project->date_fin_prevue }}"
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
                                       value="{{ old('date_fin', $phase->date_fin) }}"
                                       min="{{ $phase->project->date_debut }}"
                                       max="{{ $phase->project->date_fin_prevue }}"
                                       required>
                                @error('date_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Historique --}}
                        <div class="alert alert-info">
                            <h6 class="alert-heading">
                                <i class="fas fa-history me-2"></i>
                                Historique
                            </h6>
                            <ul class="mb-0 ps-3 small">
                                <li>Créée le: {{ $phase->created_at->format('d/m/Y à H:i') }}</li>
                                <li>Dernière modification: {{ $phase->updated_at->format('d/m/Y à H:i') }}</li>
                            </ul>
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
                                       value="{{ old('cout', $phase->cout) }}"
                                       step="0.01"
                                       min="0"
                                       required>
                                <span class="input-group-text">€</span>
                                @error('cout')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">
                                <i class="fas fa-calculator me-1"></i>
                                Budget projet: {{ number_format($phase->project->budget_prevu, 0, ',', ' ') }} €
                                @php
                                    $totalPhasesExcludingCurrent = $phase->project->projectPhases->where('id', '!=', $phase->id)->sum('cout');
                                @endphp
                                | Autres phases: {{ number_format($totalPhasesExcludingCurrent, 0, ',', ' ') }} €
                            </div>
                        </div>

                        {{-- Avancement --}}
                        <div class="mb-3">
                            <label for="avancement" class="form-label">
                                Avancement (%) <span class="text-danger">*</span>
                            </label>
                            <input type="range" 
                                   class="form-range" 
                                   id="avancement" 
                                   name="avancement" 
                                   min="0" 
                                   max="100" 
                                   step="5"
                                   value="{{ old('avancement', $phase->avancement) }}"
                                   required>
                            <div class="d-flex justify-content-between">
                                <span class="small text-muted">0%</span>
                                <span class="badge bg-primary fs-6" id="avancement-value">{{ old('avancement', $phase->avancement) }}%</span>
                                <span class="small text-muted">100%</span>
                            </div>
                            @error('avancement')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Progression visuelle --}}
                        <div class="progress mb-3" style="height: 30px;">
                            <div class="progress-bar bg-success" 
                                 role="progressbar" 
                                 id="avancement-bar"
                                 style="width: {{ old('avancement', $phase->avancement) }}%">
                                <strong id="avancement-bar-text">{{ old('avancement', $phase->avancement) }}%</strong>
                            </div>
                        </div>

                        {{-- Statut automatique --}}
                        <div class="alert alert-light border">
                            <h6 class="mb-2">
                                <i class="fas fa-info-circle text-primary me-2"></i>
                                Statut de la phase
                            </h6>
                            <div id="phase-status">
                                @if($phase->avancement == 0)
                                    <span class="badge bg-secondary">Non démarrée</span>
                                @elseif($phase->avancement < 100)
                                    <span class="badge bg-primary">En cours ({{ $phase->avancement }}%)</span>
                                @else
                                    <span class="badge bg-success">Terminée</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.projects.show', $phase->project) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Retour au projet
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Enregistrer les modifications
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

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
    const avancementBar = document.getElementById('avancement-bar');
    const avancementBarText = document.getElementById('avancement-bar-text');
    const phaseStatus = document.getElementById('phase-status');
    
    avancementInput.addEventListener('input', function() {
        const value = this.value;
        avancementValue.textContent = value + '%';
        avancementBar.style.width = value + '%';
        avancementBarText.textContent = value + '%';
        
        // Mise à jour du statut
        let statusBadge;
        if (value == 0) {
            statusBadge = '<span class="badge bg-secondary">Non démarrée</span>';
        } else if (value < 100) {
            statusBadge = '<span class="badge bg-primary">En cours (' + value + '%)</span>';
        } else {
            statusBadge = '<span class="badge bg-success">Terminée</span>';
        }
        phaseStatus.innerHTML = statusBadge;
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
</script>
@endpush
