@extends('layouts.admin')

@section('title', 'Nouveau Financement')

@section('content')
<x-project.layouts.admin
    title="Nouveau Financement"
    :breadcrumbs="[
        ['label' => 'Tableau de bord', 'url' => route('dashboard')],
        ['label' => 'Projets', 'url' => route('admin.projects.index')],
        ['label' => $project->titre, 'url' => route('admin.projects.show', $project)],
        ['label' => 'Nouveau Financement', 'url' => null]
    ]">

<div class="container-fluid py-4">
    {{-- En-tête avec contexte du projet --}}
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Projets</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.projects.show', $project) }}">{{ $project->titre }}</a></li>
                <li class="breadcrumb-item active">Nouveau Financement</li>
            </ol>
        </nav>
        <h1 class="h2 mb-3">Ajouter un Financement</h1>
        
        {{-- Contexte du projet --}}
        <div class="card border-success bg-light mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="mb-2">
                            <i class="fas fa-project-diagram text-success me-2"></i>
                            {{ $project->titre }}
                        </h5>
                        <div class="d-flex gap-3 text-muted small">
                            <span>
                                <i class="fas fa-euro-sign me-1"></i>
                                Budget: {{ number_format($project->budget_prevu, 0, ',', ' ') }} €
                            </span>
                            <span>
                                <i class="fas fa-check-circle me-1"></i>
                                Financé: {{ number_format($project->fundingTotal(), 0, ',', ' ') }} €
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Taux de financement</div>
                        @php
                            $tauxFinancement = $project->budget_prevu > 0 ? ($project->fundingTotal() / $project->budget_prevu) * 100 : 0;
                        @endphp
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar bg-success" 
                                 role="progressbar" 
                                 style="width: {{ min($tauxFinancement, 100) }}%">
                                {{ number_format($tauxFinancement, 1) }}%
                            </div>
                        </div>
                        <small class="text-muted">
                            Restant: {{ number_format($project->budgetRemaining(), 0, ',', ' ') }} €
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.projects.funding.store', $project) }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <input type="hidden" name="project_id" value="{{ $project->id }}">

        <div class="row">
            {{-- Colonne gauche --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-hand-holding-usd me-2"></i>
                            Source du Financement
                        </h5>
                    </div>
                    <div class="card-body">
                        {{-- Source --}}
                        <div class="mb-3">
                            <label for="source" class="form-label">
                                Type de financement <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('source') is-invalid @enderror" 
                                    id="source" 
                                    name="source"
                                    required>
                                <option value="">Sélectionner une source</option>
                                <option value="municipal" {{ old('source') === 'municipal' ? 'selected' : '' }}>
                                    🏛️ Municipal
                                </option>
                                <option value="régional" {{ old('source') === 'régional' ? 'selected' : '' }}>
                                    🏛️ Régional
                                </option>
                                <option value="fédéral" {{ old('source') === 'fédéral' ? 'selected' : '' }}>
                                    🏛️ Fédéral
                                </option>
                                <option value="européen" {{ old('source') === 'européen' ? 'selected' : '' }}>
                                    🇪🇺 Européen
                                </option>
                                <option value="privé" {{ old('source') === 'privé' ? 'selected' : '' }}>
                                    🏢 Privé
                                </option>
                                <option value="don" {{ old('source') === 'don' ? 'selected' : '' }}>
                                    ❤️ Don (citoyen)
                                </option>
                            </select>
                            @error('source')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Le type détermine la source du financement
                            </div>
                        </div>

                        {{-- Donateur (visible uniquement si source = don) --}}
                        <div class="mb-3" id="donateur-group" style="display: none;">
                            <label for="donateur_id" class="form-label">
                                Donateur (Citoyen) <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('donateur_id') is-invalid @enderror" 
                                    id="donateur_id" 
                                    name="donateur_id">
                                <option value="">Sélectionner un citoyen</option>
                                @foreach(\App\Models\User::where('role', 'citoyen')->get() as $citoyen)
                                    <option value="{{ $citoyen->id }}" {{ old('donateur_id') == $citoyen->id ? 'selected' : '' }}>
                                        {{ $citoyen->name }} ({{ $citoyen->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('donateur_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-user me-1"></i>
                                Obligatoire si la source est "Don"
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="description" class="form-label">
                                Description / Notes
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4"
                                      placeholder="Ex: Subvention de la région pour modernisation...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Colonne droite --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-euro-sign me-2"></i>
                            Montant et Statut
                        </h5>
                    </div>
                    <div class="card-body">
                        {{-- Montant --}}
                        <div class="mb-3">
                            <label for="montant" class="form-label">
                                Montant (€) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number" 
                                       class="form-control @error('montant') is-invalid @enderror" 
                                       id="montant" 
                                       name="montant" 
                                       value="{{ old('montant') }}"
                                       step="0.01"
                                       min="0"
                                       max="{{ $project->budgetRemaining() }}"
                                       required>
                                <span class="input-group-text">€</span>
                                @error('montant')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text" id="montant-info">
                                <i class="fas fa-calculator me-1"></i>
                                Budget restant: <strong>{{ number_format($project->budgetRemaining(), 0, ',', ' ') }} €</strong>
                            </div>
                        </div>

                        {{-- Date de versement --}}
                        <div class="mb-3">
                            <label for="date_versement" class="form-label">
                                Date de versement <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   class="form-control @error('date_versement') is-invalid @enderror" 
                                   id="date_versement" 
                                   name="date_versement" 
                                   value="{{ old('date_versement', date('Y-m-d')) }}"
                                   max="{{ date('Y-m-d') }}"
                                   required>
                            @error('date_versement')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Ne peut pas être dans le futur
                            </div>
                        </div>

                        {{-- Résumé --}}
                        <div class="alert alert-info">
                            <h6 class="alert-heading">
                                <i class="fas fa-chart-pie me-2"></i>
                                Résumé des financements
                            </h6>
                            <ul class="mb-0 ps-3 small">
                                <li>Budget projet: <strong>{{ number_format($project->budget_prevu, 0, ',', ' ') }} €</strong></li>
                                <li>Déjà financé: <strong>{{ number_format($project->fundingTotal(), 0, ',', ' ') }} €</strong></li>
                                <li>Restant à financer: <strong>{{ number_format($project->budgetRemaining(), 0, ',', ' ') }} €</strong></li>
                                <li>Nombre de financements: <strong>{{ $project->fundings->count() }}</strong></li>
                            </ul>
                        </div>
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
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-2"></i>
                        Ajouter le financement
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

    // Toggle donateur field based on source
    const sourceSelect = document.getElementById('source');
    const donateurGroup = document.getElementById('donateur-group');
    const donateurSelect = document.getElementById('donateur_id');

    function toggleDonateurField() {
        if (sourceSelect.value === 'don') {
            donateurGroup.style.display = 'block';
            donateurSelect.required = true;
        } else {
            donateurGroup.style.display = 'none';
            donateurSelect.required = false;
            donateurSelect.value = '';
        }
    }

    sourceSelect.addEventListener('change', toggleDonateurField);
    
    // Trigger on page load
    toggleDonateurField();

    // Validation du montant en temps réel
    const montantInput = document.getElementById('montant');
    const montantInfo = document.getElementById('montant-info');
    const budgetRestant = {{ $project->budgetRemaining() }};

    montantInput.addEventListener('input', function() {
        const montant = parseFloat(this.value) || 0;
        const restantApres = budgetRestant - montant;
        
        if (montant > budgetRestant) {
            montantInfo.innerHTML = '<i class="fas fa-exclamation-triangle text-danger me-1"></i> <span class="text-danger">Le montant dépasse le budget restant!</span>';
            this.setCustomValidity('Le montant ne peut pas dépasser le budget restant');
        } else {
            montantInfo.innerHTML = '<i class="fas fa-calculator me-1"></i> Budget restant: <strong>' + budgetRestant.toLocaleString('fr-FR') + ' €</strong> | Après ce financement: <strong class="text-' + (restantApres >= 0 ? 'success' : 'danger') + '">' + restantApres.toLocaleString('fr-FR') + ' €</strong>';
            this.setCustomValidity('');
        }
    });

    // Calculer le pourcentage de financement
    montantInput.addEventListener('blur', function() {
        const montant = parseFloat(this.value) || 0;
        const budgetTotal = {{ $project->budget_prevu }};
        const pourcentage = (montant / budgetTotal * 100).toFixed(2);
        
        if (montant > 0) {
            console.log('Ce financement représente ' + pourcentage + '% du budget total');
        }
    });
</script>
@endpush

</x-project.layouts.admin>
@endsection
