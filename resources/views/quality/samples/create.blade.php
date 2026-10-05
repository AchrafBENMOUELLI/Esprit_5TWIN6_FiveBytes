<style>{!! file_get_contents(resource_path('views/components/quality/samples/samples.css')) !!}</style>

@props(['zones', 'infrastructures', 'thresholds'])

<div class="sample-form-container">
    <div class="sample-header">
        <div class="d-flex align-items-center gap-3 mb-3">
            <a href="{{ route('admin.quality.samples.index') }}" class="back-link">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h2>Nouvel échantillon d'eau</h2>
                <p>Enregistrer une nouvelle analyse de qualité</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.quality.samples.store') }}">
        @csrf

        {{-- Informations générales --}}
        <div class="form-section">
            <h3>Informations de prélèvement</h3>
            
            <div class="row g-3">
                {{-- Zone --}}
                <div class="col-md-6">
                    <label for="zone_id" class="form-label">Zone <span class="text-danger">*</span></label>
                    <select name="zone_id" id="zone_id" class="form-select @error('zone_id') is-invalid @enderror" required>
                        <option value="">Sélectionner une zone</option>
                        @foreach($zones as $zone)
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
                <div class="col-md-6">
                    <label for="infrastructure_id" class="form-label">Infrastructure (optionnel)</label>
                    <select name="infrastructure_id" id="infrastructure_id" class="form-select @error('infrastructure_id') is-invalid @enderror">
                        <option value="">Aucune infrastructure spécifique</option>
                        @foreach($infrastructures as $infra)
                            <option value="{{ $infra->id }}" {{ old('infrastructure_id') == $infra->id ? 'selected' : '' }}>
                                {{ $infra->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('infrastructure_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Date de prélèvement --}}
                <div class="col-md-6">
                    <label for="date_prelevement" class="form-label">Date et heure de prélèvement <span class="text-danger">*</span></label>
                    <input type="datetime-local" 
                           name="date_prelevement" 
                           id="date_prelevement" 
                           class="form-control @error('date_prelevement') is-invalid @enderror"
                           value="{{ old('date_prelevement', now()->format('Y-m-d\TH:i')) }}"
                           max="{{ now()->format('Y-m-d\TH:i') }}"
                           required>
                    @error('date_prelevement')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Paramètres analysés --}}
        <div class="form-section">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Paramètres analysés</h3>
                <small class="text-muted">Au moins un paramètre requis</small>
            </div>

            @foreach($thresholds as $index => $threshold)
                <div class="parameter-row">
                    <div class="parameter-info">
                        <div class="parameter-name">
                            <i class="bi bi-droplet-fill"></i>
                            <span>{{ $threshold->parametre->label() }}</span>
                        </div>
                        <div class="parameter-threshold">
                            Seuils: 
                            @if($threshold->valeur_min)
                                min {{ $threshold->valeur_min }}
                            @endif
                            @if($threshold->valeur_min && $threshold->valeur_max)
                                -
                            @endif
                            @if($threshold->valeur_max)
                                max {{ $threshold->valeur_max }}
                            @endif
                            {{ $threshold->unite }}
                        </div>
                    </div>
                    
                    <div class="parameter-input">
                        <input type="hidden" 
                               name="parameters[{{ $index }}][threshold_id]" 
                               value="{{ $threshold->id }}">
                        <input type="number" 
                               step="0.001"
                               name="parameters[{{ $index }}][valeur]" 
                               value="{{ old("parameters.{$index}.valeur") }}"
                               placeholder="Valeur"
                               class="form-control @error("parameters.{$index}.valeur") is-invalid @enderror">
                        @error("parameters.{$index}.valeur")
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="parameter-unit">
                        {{ $threshold->unite }}
                    </div>
                </div>
            @endforeach

            @error('parameters')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>

        {{-- Actions --}}
        <div class="form-actions">
            <a href="{{ route('admin.quality.samples.index') }}" class="btn btn-secondary">
                <i class="bi bi-x-lg me-2"></i> Annuler
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-2"></i> Enregistrer l'analyse
            </button>
        </div>
    </form>
</div>
