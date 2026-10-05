{{-- Modal Seuils --}}
<div class="modal fade" id="thresholdsModal" tabindex="-1" aria-labelledby="thresholdsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="thresholdsModalLabel">
                    <i class="bi bi-bar-chart me-2"></i>Seuils de qualité
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Paramètre</th>
                                <th>Unité</th>
                                <th>Min</th>
                                <th>Max</th>
                                <th>Niveau alerte</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Quality\Threshold::all() as $threshold)
                                <tr>
                                    <td><strong>{{ $threshold->parametre->label() }}</strong></td>
                                    <td><span class="text-muted">{{ $threshold->unite }}</span></td>
                                    <td>{{ $threshold->valeur_min ?? '-' }}</td>
                                    <td>{{ $threshold->valeur_max ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $threshold->niveau_alerte->value === 'critique' ? 'danger' : ($threshold->niveau_alerte->value === 'eleve' ? 'warning' : 'info') }}">
                                            {{ $threshold->niveau_alerte->label() }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-2"></i>Fermer
                </button>
            </div>
        </div>
    </div>
</div>
