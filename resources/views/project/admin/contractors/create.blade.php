@extends('components.project.layouts.admin')

@section('title', 'Nouveau Contractant')

@section('content')
<div class="container-fluid py-4">
    {{-- En-tête --}}
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.contractors.index') }}">Contractants</a></li>
                <li class="breadcrumb-item active">Nouveau</li>
            </ol>
        </nav>
        <h1 class="h2 mb-1">Ajouter un Nouveau Contractant</h1>
        <p class="text-muted">Remplissez les informations du contractant / prestataire</p>
    </div>

    <form action="{{ route('admin.contractors.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <div class="row">
            {{-- Colonne gauche - Informations générales --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-building me-2"></i>
                            Informations de l'Entreprise
                        </h5>
                    </div>
                    <div class="card-body">
                        {{-- Nom --}}
                        <div class="mb-3">
                            <label for="nom" class="form-label">
                                Nom du contractant <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nom') is-invalid @enderror" 
                                   id="nom" 
                                   name="nom" 
                                   value="{{ old('nom') }}"
                                   placeholder="Ex: Entreprise Dupont SARL"
                                   required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Spécialité --}}
                        <div class="mb-3">
                            <label for="specialite" class="form-label">
                                Spécialité <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('specialite') is-invalid @enderror" 
                                   id="specialite" 
                                   name="specialite" 
                                   value="{{ old('specialite') }}"
                                   placeholder="Ex: Plomberie, Électricité, Génie civil..."
                                   list="specialites"
                                   required>
                            <datalist id="specialites">
                                <option value="Plomberie">
                                <option value="Électricité">
                                <option value="Génie civil">
                                <option value="Maçonnerie">
                                <option value="Menuiserie">
                                <option value="Peinture">
                                <option value="Climatisation">
                                <option value="Terrassement">
                                <option value="Travaux publics">
                            </datalist>
                            @error('specialite')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Commencez à taper pour voir des suggestions
                            </div>
                        </div>

                        {{-- Adresse --}}
                        <div class="mb-3">
                            <label for="adresse" class="form-label">
                                Adresse complète <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('adresse') is-invalid @enderror" 
                                      id="adresse" 
                                      name="adresse" 
                                      rows="3"
                                      placeholder="Adresse, Code postal, Ville"
                                      required>{{ old('adresse') }}</textarea>
                            @error('adresse')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Colonne droite - Coordonnées --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-address-card me-2"></i>
                            Coordonnées de Contact
                        </h5>
                    </div>
                    <div class="card-body">
                        {{-- Téléphone --}}
                        <div class="mb-3">
                            <label for="telephone" class="form-label">
                                Téléphone <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-phone"></i>
                                </span>
                                <input type="tel" 
                                       class="form-control @error('telephone') is-invalid @enderror" 
                                       id="telephone" 
                                       name="telephone" 
                                       value="{{ old('telephone') }}"
                                       placeholder="Ex: 01 23 45 67 89 ou +33 1 23 45 67 89"
                                       pattern="^(\+33\s?|0)[1-9](\s?\d{2}){4}$"
                                       required>
                                @error('telephone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">
                                Format: 01 23 45 67 89 ou +33 1 23 45 67 89
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                Email <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}"
                                       placeholder="contact@entreprise.fr"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Informations supplémentaires --}}
                        <div class="alert alert-info">
                            <h6 class="alert-heading">
                                <i class="fas fa-lightbulb me-2"></i>
                                Informations importantes
                            </h6>
                            <ul class="mb-0 ps-3">
                                <li>Assurez-vous que les coordonnées sont à jour</li>
                                <li>L'email sera utilisé pour les notifications</li>
                                <li>Le contractant pourra être assigné à des phases de projet</li>
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
                    <a href="{{ route('admin.contractors.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check me-2"></i>
                        Créer le contractant
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

    // Formatage automatique du numéro de téléphone
    document.getElementById('telephone').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s/g, '');
        if (value.startsWith('+33')) {
            value = value.replace(/(\+33)(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/, '$1 $2 $3 $4 $5 $6');
        } else if (value.startsWith('0')) {
            value = value.replace(/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/, '$1 $2 $3 $4 $5');
        }
        e.target.value = value.trim();
    });
</script>
@endpush

@push('styles')
<style>
    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
</style>
@endpush
