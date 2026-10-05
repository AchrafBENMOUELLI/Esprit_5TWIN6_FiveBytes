{{-- Modal Alertes --}}
<div class="modal fade" id="alertsModal" tabindex="-1" aria-labelledby="alertsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="alertsModalLabel">
                    <i class="bi bi-exclamation-triangle me-2"></i>Alertes qualité
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                @php
                    $alerts = \App\Models\Quality\QualityAlert::with('sample.zone')
                        ->whereNull('date_resolution')
                        ->latest()
                        ->get();
                @endphp
                @forelse($alerts as $alert)
                    <div class="alert alert-{{ $alert->niveau->value === 'critique' ? 'danger' : ($alert->niveau->value === 'eleve' ? 'warning' : 'info') }} d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <div class="mb-2">
                                <span class="badge bg-{{ $alert->niveau->value === 'critique' ? 'danger' : ($alert->niveau->value === 'eleve' ? 'warning' : 'info') }} me-2">
                                    {{ $alert->niveau->label() }}
                                </span>
                                @if($alert->publiee)
                                    <span class="badge bg-secondary">Publiée</span>
                                @endif
                            </div>
                            <p class="mb-1"><strong>{{ $alert->message }}</strong></p>
                            <small class="text-muted">
                                <i class="bi bi-geo-alt me-1"></i>Zone: {{ $alert->sample->zone->nom }} • 
                                <i class="bi bi-clock me-1"></i>{{ $alert->created_at->diffForHumans() }}
                            </small>
                        </div>
                        <form method="POST" action="{{ route('admin.quality.alerts.resolve', $alert) }}" class="ms-3">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="bi bi-check-lg me-1"></i>Résoudre
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-check-circle" style="font-size: 4rem; opacity: 0.3;"></i>
                        <h5 class="mt-3">Aucune alerte active</h5>
                        <p>Toutes les alertes ont été résolues</p>
                    </div>
                @endforelse
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-2"></i>Fermer
                </button>
            </div>
        </div>
    </div>
</div>
