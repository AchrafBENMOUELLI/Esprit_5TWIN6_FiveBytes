@extends('components.project.layouts.admin')

@section('title', 'Nouveau Document')

@section('content')
<div class="container-fluid py-4">
    {{-- En-tête avec contexte du projet --}}
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Projets</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.projects.show', $project) }}">{{ $project->titre }}</a></li>
                <li class="breadcrumb-item active">Nouveau Document</li>
            </ol>
        </nav>
        <h1 class="h2 mb-3">Ajouter un Document</h1>
        
        {{-- Contexte du projet --}}
        <div class="card border-info bg-light mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-9">
                        <h5 class="mb-2">
                            <i class="fas fa-project-diagram text-info me-2"></i>
                            {{ $project->titre }}
                        </h5>
                        <div class="d-flex gap-3 text-muted small">
                            <span>
                                <i class="fas fa-file-alt me-1"></i>
                                {{ $project->projectDocuments->count() }} document(s) existant(s)
                            </span>
                            <span class="badge bg-{{ $project->statut === 'en_cours' ? 'success' : 'secondary' }}">
                                {{ ucfirst(str_replace('_', ' ', $project->statut)) }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3 text-end">
                        <i class="fas fa-upload fa-3x text-info opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.project-documents.store') }}" 
          method="POST" 
          enctype="multipart/form-data"
          class="needs-validation" 
          novalidate>
        @csrf
        <input type="hidden" name="project_id" value="{{ $project->id }}">

        <div class="row">
            {{-- Colonne principale --}}
            <div class="col-md-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-file-upload me-2"></i>
                            Upload de Fichier
                        </h5>
                    </div>
                    <div class="card-body">
                        {{-- Zone de drag & drop --}}
                        <div class="mb-4">
                            <label for="fichier" class="form-label">
                                Fichier <span class="text-danger">*</span>
                            </label>
                            <div class="upload-zone" id="upload-zone">
                                <div class="text-center py-5">
                                    <i class="fas fa-cloud-upload-alt fa-4x text-info mb-3"></i>
                                    <h5>Glissez-déposez votre fichier ici</h5>
                                    <p class="text-muted">ou</p>
                                    <label for="fichier" class="btn btn-info">
                                        <i class="fas fa-folder-open me-2"></i>
                                        Parcourir les fichiers
                                    </label>
                                    <input type="file" 
                                           class="form-control d-none @error('fichier') is-invalid @enderror" 
                                           id="fichier" 
                                           name="fichier"
                                           accept="*/*"
                                           required>
                                    @error('fichier')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Preview du fichier --}}
                        <div id="file-preview" class="alert alert-light border d-none">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file fa-2x text-info me-3" id="file-icon"></i>
                                    <div>
                                        <strong id="file-name"></strong>
                                        <div class="small text-muted">
                                            <span id="file-size"></span> • 
                                            <span id="file-type"></span>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger" id="remove-file">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="progress mt-3" style="height: 5px;">
                                <div class="progress-bar bg-info" style="width: 100%"></div>
                            </div>
                        </div>

                        {{-- Nom du document --}}
                        <div class="mb-3">
                            <label for="nom" class="form-label">
                                Nom du document <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nom') is-invalid @enderror" 
                                   id="nom" 
                                   name="nom" 
                                   value="{{ old('nom') }}"
                                   placeholder="Ex: Plan d'architecture 2024"
                                   required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-magic me-1"></i>
                                Le nom du fichier sera utilisé par défaut
                            </div>
                        </div>

                        {{-- Type de document --}}
                        <div class="mb-3">
                            <label for="type_document" class="form-label">
                                Type de document <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('type_document') is-invalid @enderror" 
                                    id="type_document" 
                                    name="type_document"
                                    required>
                                <option value="">Sélectionner un type</option>
                                <option value="plan" {{ old('type_document') === 'plan' ? 'selected' : '' }}>
                                    <i class="fas fa-drafting-compass"></i> Plan / Schéma
                                </option>
                                <option value="rapport" {{ old('type_document') === 'rapport' ? 'selected' : '' }}>
                                    <i class="fas fa-file-alt"></i> Rapport / Compte-rendu
                                </option>
                                <option value="photo" {{ old('type_document') === 'photo' ? 'selected' : '' }}>
                                    <i class="fas fa-camera"></i> Photo / Image
                                </option>
                                <option value="facture" {{ old('type_document') === 'facture' ? 'selected' : '' }}>
                                    <i class="fas fa-file-invoice"></i> Facture
                                </option>
                                <option value="contrat" {{ old('type_document') === 'contrat' ? 'selected' : '' }}>
                                    <i class="fas fa-file-contract"></i> Contrat
                                </option>
                                <option value="autre" {{ old('type_document') === 'autre' ? 'selected' : '' }}>
                                    <i class="fas fa-file"></i> Autre
                                </option>
                            </select>
                            @error('type_document')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                                      placeholder="Ajoutez des détails sur ce document...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Colonne latérale - Informations --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Formats Acceptés
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="small text-muted mb-2">Documents</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-light text-dark border">PDF</span>
                                <span class="badge bg-light text-dark border">DOC</span>
                                <span class="badge bg-light text-dark border">DOCX</span>
                                <span class="badge bg-light text-dark border">XLS</span>
                                <span class="badge bg-light text-dark border">XLSX</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <h6 class="small text-muted mb-2">Images</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-light text-dark border">JPG</span>
                                <span class="badge bg-light text-dark border">PNG</span>
                                <span class="badge bg-light text-dark border">GIF</span>
                                <span class="badge bg-light text-dark border">SVG</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <h6 class="small text-muted mb-2">Plans / CAO</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-light text-dark border">DWG</span>
                                <span class="badge bg-light text-dark border">DXF</span>
                                <span class="badge bg-light text-dark border">PDF</span>
                            </div>
                        </div>
                        <div class="mb-0">
                            <h6 class="small text-muted mb-2">Autres</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-light text-dark border">ZIP</span>
                                <span class="badge bg-light text-dark border">RAR</span>
                                <span class="badge bg-light text-dark border">TXT</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning">
                    <h6 class="alert-heading">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Important
                    </h6>
                    <ul class="mb-0 ps-3 small">
                        <li>Taille maximum: <strong>10 Mo</strong></li>
                        <li>Les fichiers sont sécurisés</li>
                        <li>Accessibles uniquement aux administrateurs</li>
                        <li>Sauvegarde automatique</li>
                    </ul>
                </div>

                <div class="card border-0 bg-light">
                    <div class="card-body text-center">
                        <i class="fas fa-shield-alt fa-3x text-success mb-2"></i>
                        <p class="small text-muted mb-0">
                            Vos documents sont<br><strong>sécurisés et chiffrés</strong>
                        </p>
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
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-upload me-2"></i>
                        Upload le document
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

    // Gestion du fichier
    const fileInput = document.getElementById('fichier');
    const uploadZone = document.getElementById('upload-zone');
    const filePreview = document.getElementById('file-preview');
    const nomInput = document.getElementById('nom');

    // Preview du fichier
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            displayFilePreview(file);
        }
    });

    function displayFilePreview(file) {
        // Afficher le preview
        uploadZone.classList.add('d-none');
        filePreview.classList.remove('d-none');
        
        // Nom du fichier
        document.getElementById('file-name').textContent = file.name;
        
        // Auto-remplir le champ nom si vide
        if (!nomInput.value) {
            nomInput.value = file.name.replace(/\.[^/.]+$/, ""); // Remove extension
        }
        
        // Taille
        const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
        document.getElementById('file-size').textContent = sizeMB + ' MB';
        
        // Type
        document.getElementById('file-type').textContent = file.type || 'Type inconnu';
        
        // Icône selon le type
        const icon = document.getElementById('file-icon');
        const ext = file.name.split('.').pop().toLowerCase();
        
        icon.className = 'fas fa-2x text-info me-3';
        if (['pdf'].includes(ext)) icon.classList.add('fa-file-pdf');
        else if (['doc', 'docx'].includes(ext)) icon.classList.add('fa-file-word');
        else if (['xls', 'xlsx'].includes(ext)) icon.classList.add('fa-file-excel');
        else if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) icon.classList.add('fa-file-image');
        else if (['zip', 'rar'].includes(ext)) icon.classList.add('fa-file-archive');
        else icon.classList.add('fa-file');
    }

    // Bouton supprimer fichier
    document.getElementById('remove-file').addEventListener('click', function() {
        fileInput.value = '';
        uploadZone.classList.remove('d-none');
        filePreview.classList.add('d-none');
    });

    // Drag & Drop
    uploadZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.add('border-info', 'bg-light');
    });

    uploadZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.remove('border-info', 'bg-light');
    });

    uploadZone.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.remove('border-info', 'bg-light');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            displayFilePreview(files[0]);
        }
    });
</script>
@endpush

@push('styles')
<style>
    .upload-zone {
        border: 3px dashed #dee2e6;
        border-radius: 0.5rem;
        transition: all 0.3s;
        cursor: pointer;
    }
    .upload-zone:hover {
        border-color: #0dcaf0;
        background-color: #f8f9fa;
    }
    .upload-zone.border-info {
        border-color: #0dcaf0 !important;
    }
</style>
@endpush
