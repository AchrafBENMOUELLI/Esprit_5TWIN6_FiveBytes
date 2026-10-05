@props(['sample'])

{{-- Modal Show Échantillon --}}
<div class="modal fade" id="showSampleModal{{ $sample->id }}" tabindex="-1" aria-labelledby="showSampleModalLabel{{ $sample->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="showSampleModalLabel{{ $sample->id }}">
                    <i class="bi bi-eye me-2"></i>Détails - Échantillon #{{ $sample->id }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        {{-- Résultat global --}}
                        <div class="alert {{ $sample->resultat_global?->value === 'conforme' ? 'alert-success' : 'alert-danger' }} mb-4">
                            <h6 class="mb-0">
                                <i class="bi bi-{{ $sample->resultat_global?->value === 'conforme' ? 'check-circle' : 'x-circle' }} me-2"></i>
                                Résultat: 
                                <strong>{{ $sample->resultat_global?->label() ?? 'Non défini' }}</strong>
                            </h6>
                        </div>

                        {{-- Paramètres --}}
                        <h6 class="mb-3 pb-2 border-bottom">
                            <i class="bi bi-droplet-fill me-2"></i>Paramètres analysés
                        </h6>
                        <div class="row g-3">
                            @foreach($sample->parameters as $parameter)
                                <div class="col-md-6">
                                    <div class="card {{ $parameter->depasse_seuil ? 'border-danger' : 'border-success' }}">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="mb-1">
                                                        @if($parameter->depasse_seuil)
                                                            <i class="bi bi-exclamation-triangle text-danger me-1"></i>
                                                        @else
                                                            <i class="bi bi-check-circle text-success me-1"></i>
                                                        @endif
                                                        {{ $parameter->threshold->parametre->label() }}
                                                    </h6>
                                                    <small class="text-muted">
                                                        Seuils: 
                                                        @if($parameter->threshold->valeur_min) {{ $parameter->threshold->valeur_min }} @endif
                                                        @if($parameter->threshold->valeur_min && $parameter->threshold->valeur_max) - @endif
                                                        @if($parameter->threshold->valeur_max) {{ $parameter->threshold->valeur_max }} @endif
                                                        {{ $parameter->threshold->unite }}
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <span class="fs-4 fw-bold {{ $parameter->depasse_seuil ? 'text-danger' : 'text-success' }}">
                                                    {{ $parameter->valeur }}
                                                </span>
                                                <span class="text-muted ms-1">{{ $parameter->threshold->unite }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Alertes --}}
                        @if($sample->alerts->isNotEmpty())
                            <h6 class="mt-4 mb-3 pb-2 border-bottom">
                                <i class="bi bi-exclamation-triangle me-2"></i>Alertes
                            </h6>
                            @foreach($sample->alerts as $alert)
                                <div class="alert alert-{{ $alert->niveau->value === 'critique' ? 'danger' : ($alert->niveau->value === 'eleve' ? 'warning' : 'info') }} mb-2">
                                    <span class="badge bg-{{ $alert->niveau->value === 'critique' ? 'danger' : ($alert->niveau->value === 'eleve' ? 'warning' : 'info') }} me-2">
                                        {{ $alert->niveau->label() }}
                                    </span>
                                    {{ $alert->message }}
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title mb-3">
                                    <i class="bi bi-info-circle me-2"></i>Informations
                                </h6>
                                <div class="mb-3">
                                    <small class="text-muted text-uppercase d-block mb-1">Zone</small>
                                    <div class="fw-semibold">
                                        <i class="bi bi-geo-alt me-1"></i>{{ $sample->zone->nom }}
                                    </div>
                                </div>
                                @if($sample->infrastructure)
                                <div class="mb-3">
                                    <small class="text-muted text-uppercase d-block mb-1">Infrastructure</small>
                                    <div class="fw-semibold">
                                        <i class="bi bi-building me-1"></i>{{ $sample->infrastructure->nom }}
                                    </div>
                                </div>
                                @endif
                                <div class="mb-3">
                                    <small class="text-muted text-uppercase d-block mb-1">Prélevé par</small>
                                    <div class="fw-semibold">
                                        <i class="bi bi-person me-1"></i>{{ $sample->preleveur->name }}
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <small class="text-muted text-uppercase d-block mb-1">Date prélèvement</small>
                                    <div class="fw-semibold">
                                        <i class="bi bi-calendar3 me-1"></i>{{ $sample->date_prelevement->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-2"></i>Fermer
                </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editSampleModal{{ $sample->id }}" data-bs-dismiss="modal">
                    <i class="bi bi-pencil me-2"></i>Modifier
                </button>
            </div>
        </div>
    </div>
</div>
