@props(['sample'])

{{-- Modal Edit Échantillon --}}
<div class="modal fade" id="editSampleModal{{ $sample->id }}" tabindex="-1" aria-labelledby="editSampleModalLabel{{ $sample->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="editSampleModalLabel{{ $sample->id }}">
                    <i class="bi bi-pencil me-2"></i>Modifier - Échantillon #{{ $sample->id }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <form method="POST" action="{{ route('admin.quality.samples.update', $sample) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Zone <span class="text-danger">*</span></label>
                            <select name="zone_id" class="form-select" required>
                                @foreach(\App\Models\Infrastructure\Zone::all() as $zone)
                                    <option value="{{ $zone->id }}" {{ $sample->zone_id == $zone->id ? 'selected' : '' }}>
                                        {{ $zone->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Infrastructure</label>
                            <select name="infrastructure_id" class="form-select">
                                <option value="">Aucune</option>
                                @foreach(\App\Models\Infrastructure\Infrastructure::all() as $infra)
                                    <option value="{{ $infra->id }}" {{ $sample->infrastructure_id == $infra->id ? 'selected' : '' }}>
                                        {{ $infra->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date/heure <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="date_prelevement" class="form-control" 
                                   value="{{ $sample->date_prelevement->format('Y-m-d\TH:i') }}" 
                                   max="{{ now()->format('Y-m-d\TH:i') }}" required>
                        </div>
                    </div>

                    <h6 class="mb-3 pb-2 border-bottom">
                        <i class="bi bi-droplet-fill me-2"></i>Paramètres analysés
                    </h6>
                    @php
                        $existingParams = $sample->parameters->keyBy('threshold_id');
                    @endphp
                    <div class="row g-3">
                        @foreach(\App\Models\Quality\Threshold::all() as $index => $threshold)
                            @php
                                $existingParam = $existingParams->get($threshold->id);
                            @endphp
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1">
                                                    <i class="bi bi-droplet-fill text-primary me-1"></i>
                                                    {{ $threshold->parametre->label() }}
                                                </h6>
                                                <small class="text-muted">
                                                    Seuils: 
                                                    @if($threshold->valeur_min) min {{ $threshold->valeur_min }} @endif
                                                    @if($threshold->valeur_min && $threshold->valeur_max) - @endif
                                                    @if($threshold->valeur_max) max {{ $threshold->valeur_max }} @endif
                                                    {{ $threshold->unite }}
                                                </small>
                                            </div>
                                        </div>
                                        <input type="hidden" name="parameters[{{ $index }}][threshold_id]" value="{{ $threshold->id }}">
                                        <div class="input-group">
                                            <input type="number" 
                                                   step="0.001" 
                                                   name="parameters[{{ $index }}][valeur]" 
                                                   value="{{ $existingParam?->valeur }}" 
                                                   placeholder="Valeur mesurée" 
                                                   class="form-control">
                                            <span class="input-group-text">{{ $threshold->unite }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-2"></i>Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
