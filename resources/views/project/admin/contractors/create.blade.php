@extends('layouts.admin')

@section('title', 'Nouvel Entrepreneur')

@section('content')
<x-project.layouts.admin
    title="Nouvel Entrepreneur"
    :breadcrumbs="[
        ['label' => 'Tableau de bord', 'url' => route('dashboard')],
        ['label' => 'Entrepreneurs', 'url' => route('admin.contractors.index')],
        ['label' => 'Nouveau', 'url' => null]
    ]">

<style>
    .minimal-form-card {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 1px 3px rgba(30, 64, 175, 0.08);
    }

    .minimal-input, .minimal-textarea {
        padding: 12px 16px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.2s ease;
        width: 100%;
    }

    .minimal-input:focus, .minimal-textarea:focus {
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

    .info-box h6 {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .info-box ul {
        margin-bottom: 0;
        padding-left: 20px;
    }

    .info-box li {
        margin-bottom: 4px;
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
            Nouvel Entrepreneur
        </h1>
        <p class="text-muted mb-0" style="font-size: 15px;">Remplissez les informations de l'entrepreneur</p>
    </div>

    <form action="{{ route('admin.contractors.store') }}" method="POST">
        @csrf

        <div class="row g-4">
            {{-- Left Column --}}
            <div class="col-lg-6">
                <div class="minimal-form-card h-100">
                    <h5 style="font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 24px;">
                        <i class="fas fa-building" style="margin-right: 8px; color: #3b82f6;"></i>Informations de l'Entreprise
                    </h5>

                    <div class="mb-4">
                        <label for="nom" class="minimal-label">Nom de l'entrepreneur <span style="color: #ef4444;">*</span></label>
                        <input type="text" 
                               class="minimal-input @error('nom') is-invalid @enderror" 
                               id="nom" 
                               name="nom" 
                               value="{{ old('nom') }}"
                               placeholder="Ex: Entreprise Dupont SARL">
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="specialite" class="minimal-label">Spécialité <span style="color: #ef4444;">*</span></label>
                        <input type="text" 
                               class="minimal-input @error('specialite') is-invalid @enderror" 
                               id="specialite" 
                               name="specialite" 
                               value="{{ old('specialite') }}"
                               placeholder="Ex: Plomberie, Électricité..."
                               list="specialites">
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
                        <div class="form-hint">
                            <i class="fas fa-info-circle" style="margin-right: 4px;"></i>Commencez à taper pour voir des suggestions
                        </div>
                    </div>

                    <div class="mb-0">
                        <label for="adresse" class="minimal-label">Adresse complète <span style="color: #ef4444;">*</span></label>
                        <textarea class="minimal-textarea @error('adresse') is-invalid @enderror" 
                                  id="adresse" 
                                  name="adresse" 
                                  rows="3"
                                  placeholder="Adresse, Code postal, Ville">{{ old('adresse') }}</textarea>
                        @error('adresse')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Right Column --}}
            <div class="col-lg-6">
                <div class="minimal-form-card h-100">
                    <h5 style="font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 24px;">
                        <i class="fas fa-address-card" style="margin-right: 8px; color: #3b82f6;"></i>Coordonnées de Contact
                    </h5>

                    <div class="mb-4">
                        <label for="telephone" class="minimal-label">Téléphone <span style="color: #ef4444;">*</span></label>
                        <div class="d-flex align-items-center" style="gap: 12px;">
                            <div style="flex-shrink: 0; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(96, 165, 250, 0.15)); border-radius: 10px; color: #3b82f6;">
                                <i class="fas fa-phone" style="font-size: 14px;"></i>
                            </div>
                            <input type="tel" 
                                   class="minimal-input @error('telephone') is-invalid @enderror" 
                                   id="telephone" 
                                   name="telephone" 
                                   value="{{ old('telephone') }}"
                                   placeholder="Ex: 01 23 45 67 89"
                                   style="flex: 1;">
                        </div>
                        @error('telephone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-hint">Format: 01 23 45 67 89 ou +33 1 23 45 67 89</div>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="minimal-label">Email <span style="color: #ef4444;">*</span></label>
                        <div class="d-flex align-items-center" style="gap: 12px;">
                            <div style="flex-shrink: 0; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(96, 165, 250, 0.15)); border-radius: 10px; color: #3b82f6;">
                                <i class="fas fa-envelope" style="font-size: 14px;"></i>
                            </div>
                            <input type="email" 
                                   class="minimal-input @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   placeholder="contact@entreprise.fr"
                                   style="flex: 1;">
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="info-box">
                        <h6>
                            <i class="fas fa-lightbulb" style="margin-right: 8px; color: #f59e0b;"></i>Informations importantes
                        </h6>
                        <ul>
                            <li>Assurez-vous que les coordonnées sont à jour</li>
                            <li>L'email sera utilisé pour les notifications</li>
                            <li>L'entrepreneur pourra être assigné à des phases</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="minimal-form-card mt-4">
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.contractors.index') }}" class="minimal-btn minimal-btn-ghost">
                    <i class="fas fa-arrow-left" style="margin-right: 8px; font-size: 11px;"></i>Annuler
                </a>
                <button type="submit" class="minimal-btn minimal-btn-primary">
                    <i class="fas fa-check" style="margin-right: 8px; font-size: 11px;"></i>Créer l'entrepreneur
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Form ready for server-side validation only
    console.log('Contractor create form loaded - server-side validation active');
</script>
@endpush

</x-project.layouts.admin>
@endsection
