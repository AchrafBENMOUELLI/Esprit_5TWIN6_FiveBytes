{{-- Modal Création Échantillon --}}
<div class="modal fade" id="createSampleModal" tabindex="-1" aria-labelledby="createSampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="createSampleModalLabel">
                    <i class="bi bi-plus-lg me-2"></i>Nouvel échantillon d'eau
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <form method="POST" action="{{ route('admin.quality.samples.store') }}">
                @csrf
                <div class="modal-body">
                    @php
                        $zones = \App\Models\Infrastructure\Zone::all();
                        $infrastructures = \App\Models\Infrastructure\Infrastructure::all();
                        $thresholds = \App\Models\Quality\Threshold::all();
                    @endphp
                    
                    @if($zones->isEmpty())
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Aucune zone disponible. Veuillez créer des zones d'abord.
                        </div>
                    @elseif($thresholds->isEmpty())
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Aucun seuil défini. Veuillez exécuter les seeders: <code>php artisan db:seed --class=Database\\Seeders\\Quality\\ThresholdSeeder</code>
                        </div>
                    @else
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="zone_id" class="form-label">Zone <span class="text-danger">*</span></label>
                                <select name="zone_id" id="zone_id" class="form-select" required>
                                    <option value="">Sélectionner une zone</option>
                                    @foreach($zones as $zone)
                                        <option value="{{ $zone->id }}">{{ $zone->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="infrastructure_id" class="form-label">Infrastructure</label>
                                <select name="infrastructure_id" id="infrastructure_id" class="form-select">
                                    <option value="">Aucune</option>
                                    @foreach($infrastructures as $infra)
                                        <option value="{{ $infra->id }}">{{ $infra->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="date_prelevement" class="form-label">Date/heure <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="date_prelevement" id="date_prelevement" 
                                       class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}" 
                                       max="{{ now()->format('Y-m-d\TH:i') }}" required>
                            </div>
                        </div>

                        <h6 class="mb-3 pb-2 border-bottom">
                            <i class="bi bi-droplet-fill me-2"></i>Paramètres analysés
                        </h6>
                        <div class="row g-3">
                            @foreach($thresholds as $index => $threshold)
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
                                                       placeholder="Valeur mesurée" 
                                                       class="form-control">
                                                <span class="input-group-text">{{ $threshold->unite }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-2"></i>Annuler
                    </button>
                    @if($zones->isNotEmpty() && $thresholds->isNotEmpty())
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>Enregistrer
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
