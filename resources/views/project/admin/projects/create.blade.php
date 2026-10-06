@extends('layouts.admin')

@section('title', 'Nouveau Projet')

@section('content')
<x-project.layouts.admin
    title="Nouveau Projet"
    :breadcrumbs="[
        ['label' => 'Tableau de bord', 'url' => route('dashboard')],
        ['label' => 'Projets', 'url' => route('admin.projects.index')],
        ['label' => 'Nouveau', 'url' => null]
    ]">

<style>
    .minimal-form-card {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 1px 3px rgba(30, 64, 175, 0.08);
    }

    .minimal-input, .minimal-textarea, .minimal-select {
        padding: 12px 16px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.2s ease;
        width: 100%;
    }

    .minimal-input:focus, .minimal-textarea:focus, .minimal-select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .minimal-label {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 8px;
        display: block;
    }

    .minimal-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 24px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        transition: all 0.2s ease;
        text-decoration: none;
        cursor: pointer;
    }

    .minimal-btn-primary {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    }

    .minimal-btn-primary:hover {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .minimal-btn-ghost {
        background: transparent;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
    }

    .minimal-btn-ghost:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .form-hint {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 6px;
    }

    .info-box {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.05), rgba(96, 165, 250, 0.05));
        border-left: 4px solid #3b82f6;
        padding: 16px;
        border-radius: 10px;
        font-size: 13px;
        color: #64748b;
    }

    .section-header {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 24px;
        padding-bottom: 12px;
        border-bottom: 1.5px solid #e2e8f0;
    }
</style>

<div class="container-fluid py-4">
    {{-- Validation Errors Alert --}}
    @if ($errors->any())
        <div class="alert alert-danger" style="border-radius: 12px; border-left: 4px solid #ef4444; background: linear-gradient(135deg, rgba(239, 68, 68, 0.05), rgba(220, 38, 38, 0.05));">
            <h6 style="font-weight: 700; margin-bottom: 12px;">
                <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>Erreurs de validation
            </h6>
            <ul style="margin-bottom: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Header --}}
    <div class="mb-4">
        <h1 class="fw-bold mb-2" style="font-size: 32px; background: linear-gradient(135deg, #1e40af, #3b82f6, #60a5fa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
            Nouveau Projet
        </h1>
        <p class="text-muted mb-0" style="font-size: 15px;">Remplissez les informations du projet de rénovation</p>
    </div>

    <form action="{{ route('admin.projects.store') }}" method="POST">
        @csrf

        <div class="row g-4">
            {{-- Main Info --}}
            <div class="col-lg-8">
                <div class="minimal-form-card mb-4">
                    <h5 class="section-header">
                        <i class="fas fa-info-circle" style="margin-right: 8px; color: #3b82f6;"></i>Informations Générales
                    </h5>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="titre" class="minimal-label">Titre du projet <span style="color: #ef4444;">*</span></label>
                            <input type="text" 
                                   class="minimal-input @error('titre') is-invalid @enderror" 
                                   id="titre" 
                                   name="titre" 
                                   value="{{ old('titre') }}"
                                   placeholder="Ex: Rénovation Station de Pompage">
                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="type" class="minimal-label">Type de projet <span style="color: #ef4444;">*</span></label>
                            <select class="minimal-select @error('type') is-invalid @enderror" id="type" name="type">
                                <option value="">Sélectionnez un type</option>
                                <option value="réparation" {{ old('type') === 'réparation' ? 'selected' : '' }}>Réparation</option>
                                <option value="modernisation" {{ old('type') === 'modernisation' ? 'selected' : '' }}>Modernisation</option>
                                <option value="extension" {{ old('type') === 'extension' ? 'selected' : '' }}>Extension</option>
                                <option value="construction" {{ old('type') === 'construction' ? 'selected' : '' }}>Construction</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="minimal-label">Description <span style="color: #ef4444;">*</span></label>
                            <textarea class="minimal-textarea @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4"
                                      placeholder="Décrivez le projet en détail...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="minimal-form-card mb-4">
                    <h5 class="section-header">
                        <i class="fas fa-map-marker-alt" style="margin-right: 8px; color: #ef4444;"></i>Localisation
                    </h5>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="zone_id" class="minimal-label">Zone <span style="color: #ef4444;">*</span></label>
                            <select class="minimal-select @error('zone_id') is-invalid @enderror" id="zone_id" name="zone_id">
                                <option value="">Sélectionnez une zone</option>
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

                        <div class="col-md-6">
                            <label for="infrastructure_id" class="minimal-label">Infrastructure</label>
                            <select class="minimal-select @error('infrastructure_id') is-invalid @enderror" id="infrastructure_id" name="infrastructure_id">
                                <option value="">Sélectionnez une infrastructure (optionnel)</option>
                                @foreach(\App\Models\Infrastructure\Infrastructure::all() as $infrastructure)
                                    <option value="{{ $infrastructure->id }}" {{ old('infrastructure_id') == $infrastructure->id ? 'selected' : '' }}>
                                        {{ $infrastructure->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('infrastructure_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-hint">
                                <i class="fas fa-info-circle" style="margin-right: 4px;"></i>L'infrastructure est optionnelle
                            </div>
                        </div>
                    </div>
                </div>

                <div class="minimal-form-card">
                    <h5 class="section-header">
                        <i class="fas fa-calendar-alt" style="margin-right: 8px; color: #06b6d4;"></i>Dates & Budget
                    </h5>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="date_debut" class="minimal-label">Date de début <span style="color: #ef4444;">*</span></label>
                            <input type="date" 
                                   class="minimal-input @error('date_debut') is-invalid @enderror" 
                                   id="date_debut" 
                                   name="date_debut" 
                                   value="{{ old('date_debut') }}">
                            @error('date_debut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="date_fin_prevue" class="minimal-label">Date de fin prévue <span style="color: #ef4444;">*</span></label>
                            <input type="date" 
                                   class="minimal-input @error('date_fin_prevue') is-invalid @enderror" 
                                   id="date_fin_prevue" 
                                   name="date_fin_prevue" 
                                   value="{{ old('date_fin_prevue') }}">
                            @error('date_fin_prevue')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="budget_prevu" class="minimal-label">Budget prévu (€) <span style="color: #ef4444;">*</span></label>
                            <div class="d-flex align-items-center" style="gap: 12px;">
                                <div style="flex-shrink: 0; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(52, 211, 153, 0.15)); border-radius: 10px; color: #10b981;">
                                    <i class="fas fa-euro-sign" style="font-size: 14px;"></i>
                                </div>
                                <input type="number" 
                                       class="minimal-input @error('budget_prevu') is-invalid @enderror" 
                                       id="budget_prevu" 
                                       name="budget_prevu" 
                                       value="{{ old('budget_prevu') }}"
                                       placeholder="Ex: 500000"
                                       min="0"
                                       step="1000"
                                       style="flex: 1;">
                            </div>
                            @error('budget_prevu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="avancement_pourcentage" class="minimal-label">Avancement initial (%)</label>
                            <input type="number" 
                                   class="minimal-input @error('avancement_pourcentage') is-invalid @enderror" 
                                   id="avancement_pourcentage" 
                                   name="avancement_pourcentage" 
                                   value="{{ old('avancement_pourcentage', 0) }}"
                                   placeholder="0-100"
                                   min="0"
                                   max="100">
                            @error('avancement_pourcentage')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                <div class="minimal-form-card mb-4">
                    <h5 class="section-header">
                        <i class="fas fa-sliders-h" style="margin-right: 8px; color: #6366f1;"></i>Statut & Responsable
                    </h5>

                    <div class="mb-4">
                        <label for="statut" class="minimal-label">Statut <span style="color: #ef4444;">*</span></label>
                        <select class="minimal-select @error('statut') is-invalid @enderror" id="statut" name="statut">
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

                    <div class="mb-0">
                        <label for="responsable_id" class="minimal-label">Responsable <span style="color: #ef4444;">*</span></label>
                        <select class="minimal-select @error('responsable_id') is-invalid @enderror" id="responsable_id" name="responsable_id">
                            <option value="">Sélectionnez un responsable</option>
                            @foreach(\App\Models\User::where('role', \App\Enums\UserRole::Admin)->get() as $user)
                                <option value="{{ $user->id }}" {{ old('responsable_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('responsable_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="info-box">
                    <h6 style="font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 8px;">
                        <i class="fas fa-lightbulb" style="margin-right: 8px; color: #f59e0b;"></i>Informations importantes
                    </h6>
                    <ul style="margin-bottom: 0; padding-left: 20px;">
                        <li>Tous les champs marqués * sont obligatoires</li>
                        <li>Vous pourrez ajouter des phases après création</li>
                        <li>Les financements peuvent être ajoutés ensuite</li>
                        <li>Les documents seront attachés après création</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="minimal-form-card mt-4">
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.projects.index') }}" class="minimal-btn minimal-btn-ghost">
                    <i class="fas fa-arrow-left" style="margin-right: 8px; font-size: 11px;"></i>Annuler
                </a>
                <button type="submit" class="minimal-btn minimal-btn-primary">
                    <i class="fas fa-check" style="margin-right: 8px; font-size: 11px;"></i>Créer le projet
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Form ready for server-side validation only
    console.log('Project create form loaded - server-side validation active');
</script>
@endpush

</x-project.layouts.admin>
@endsection
