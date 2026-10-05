<style>{!! file_get_contents(resource_path('views/components/quality/quality.css')) !!}</style>

@props(['samples' => collect()])

<div class="quality-module" x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 3000)">
    {{-- Header --}}
    <div class="quality-header">
        <div class="quality-title">
            <h2>Qualité de l'eau</h2>
            <p>Gestion des échantillons et analyses</p>
        </div>
        <div class="quality-actions">
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#thresholdsModal">
                <i class="bi bi-bar-chart me-2"></i> Seuils
            </button>
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#alertsModal">
                <i class="bi bi-exclamation-triangle me-2"></i> Alertes
            </button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSampleModal">
                <i class="bi bi-plus-lg me-2"></i> Nouvel échantillon
            </button>
        </div>
    </div>

    {{-- Messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-x-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Skeleton Loading State --}}
    <div x-show="loading" class="skeleton-container">
        {{-- Stats Skeleton --}}
        <div class="quality-stats mb-4">
            <div class="stat-card">
                <div class="skeleton skeleton-text" style="width: 60%; height: 12px; margin-bottom: 8px;"></div>
                <div class="skeleton skeleton-text" style="width: 40%; height: 32px;"></div>
            </div>
            <div class="stat-card">
                <div class="skeleton skeleton-text" style="width: 60%; height: 12px; margin-bottom: 8px;"></div>
                <div class="skeleton skeleton-text" style="width: 40%; height: 32px;"></div>
            </div>
            <div class="stat-card">
                <div class="skeleton skeleton-text" style="width: 60%; height: 12px; margin-bottom: 8px;"></div>
                <div class="skeleton skeleton-text" style="width: 40%; height: 32px;"></div>
            </div>
            <div class="stat-card">
                <div class="skeleton skeleton-text" style="width: 60%; height: 12px; margin-bottom: 8px;"></div>
                <div class="skeleton skeleton-text" style="width: 40%; height: 32px;"></div>
            </div>
        </div>

        {{-- Table Skeleton --}}
        <div class="quality-table-container">
            <table class="table quality-table">
                <thead>
                    <tr>
                        <th>Date prélèvement</th>
                        <th>Zone</th>
                        <th>Infrastructure</th>
                        <th>Prélevé par</th>
                        <th>Résultat</th>
                        <th>Alertes</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < 5; $i++)
                    <tr>
                        <td><div class="skeleton skeleton-text" style="width: 80%;"></div></td>
                        <td><div class="skeleton skeleton-text" style="width: 70%;"></div></td>
                        <td><div class="skeleton skeleton-text" style="width: 90%;"></div></td>
                        <td><div class="skeleton skeleton-text" style="width: 60%;"></div></td>
                        <td><div class="skeleton skeleton-text" style="width: 50%;"></div></td>
                        <td><div class="skeleton skeleton-text" style="width: 30%;"></div></td>
                        <td><div class="skeleton skeleton-text" style="width: 80%;"></div></td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

    {{-- Actual Content --}}
    <div x-show="!loading">
        {{-- Statistiques --}}
        @if ($samples->isNotEmpty())
            <div class="quality-stats">
                <div class="stat-card total">
                    <div class="stat-label">Total échantillons</div>
                    <div class="stat-value">{{ $samples->total() }}</div>
                </div>

                <div class="stat-card conforme">
                    <div class="stat-label">Conformes</div>
                    <div class="stat-value">
                        {{ $samples->where('resultat_global', 'conforme')->count() }}
                    </div>
                </div>

                <div class="stat-card non-conforme">
                    <div class="stat-label">Non conformes</div>
                    <div class="stat-value">
                        {{ $samples->where('resultat_global', 'non_conforme')->count() }}
                    </div>
                </div>

                <div class="stat-card taux">
                    <div class="stat-label">Taux conformité</div>
                    <div class="stat-value">
                        @php
                            $total = $samples->count();
                            $conformes = $samples->where('resultat_global', 'conforme')->count();
                            $taux = $total > 0 ? round(($conformes / $total) * 100) : 0;
                        @endphp
                        {{ $taux }}%
                    </div>
                </div>
            </div>
        @endif

        {{-- Tableau --}}
        <div class="quality-table-container">
            <table class="table table-hover quality-table">
                <thead>
                    <tr>
                        <th>Date prélèvement</th>
                        <th>Zone</th>
                        <th>Infrastructure</th>
                        <th>Prélevé par</th>
                        <th>Résultat</th>
                        <th>Alertes</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($samples as $sample)
                    <tr>
                        <td>
                            <i class="bi bi-calendar3 text-muted me-2"></i>
                            {{ $sample->date_prelevement->format('d/m/Y H:i') }}
                        </td>
                        <td>
                            <i class="bi bi-geo-alt text-muted me-2"></i>
                            <strong>{{ $sample->zone->nom }}</strong>
                        </td>
                        <td>{{ $sample->infrastructure?->nom ?? '-' }}</td>
                        <td>{{ $sample->preleveur->name }}</td>
                        <td>
                            @if ($sample->resultat_global)
                                <span class="badge-{{ $sample->resultat_global->value === 'conforme' ? 'conforme' : 'non-conforme' }}">
                                    {{ $sample->resultat_global->label() }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $alertsCount = $sample->alerts()->whereNull('date_resolution')->count();
                            @endphp
                            @if ($alertsCount > 0)
                                <span class="badge-alertes">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    {{ $alertsCount }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button type="button" 
                                        class="btn btn-sm btn-outline-primary action-btn view" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#showSampleModal{{ $sample->id }}"
                                        title="Voir">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-secondary action-btn edit" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editSampleModal{{ $sample->id }}"
                                        title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form method="POST" 
                                      action="{{ route('admin.quality.samples.destroy', $sample) }}"
                                      onsubmit="return confirm('Supprimer cet échantillon ?')"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger action-btn delete" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            <div class="empty-state">
                                <i class="bi bi-clipboard-data"></i>
                                <h3>Aucune analyse disponible</h3>
                                <p>Commencez par créer un nouvel échantillon</p>
                                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#createSampleModal">
                                    <i class="bi bi-plus-lg me-2"></i> Créer un échantillon
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($samples instanceof \Illuminate\Pagination\LengthAwarePaginator && $samples->hasPages())
        <div class="mt-4">
            {{ $samples->links('pagination::bootstrap-5') }}
        </div>
    @endif
    </div>
</div>

{{-- Include Modals --}}
<x-quality.modals.create-sample />
<x-quality.modals.thresholds />
<x-quality.modals.alerts />

@foreach($samples as $sample)
    <x-quality.modals.show-sample :sample="$sample" />
    <x-quality.modals.edit-sample :sample="$sample" />
@endforeach
