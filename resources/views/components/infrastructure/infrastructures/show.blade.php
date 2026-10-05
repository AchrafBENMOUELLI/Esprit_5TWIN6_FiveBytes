<x-admin-layout>
<style>
.crud-page { font-family: 'Segoe UI', sans-serif; }
.crud-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; }
.crud-header h1 { color: #0b2545; font-size: 1.4rem; margin: 0; }
.breadcrumb { color: #64748b; font-size: 0.85rem; margin-bottom: 0.25rem; }
.breadcrumb a { color: #1a73e8; text-decoration: none; }
.breadcrumb a:hover { text-decoration: underline; }
.header-actions { display: flex; gap: 0.6rem; flex-wrap: wrap; }
.btn { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1.1rem; border-radius: 8px; font-size: 0.9rem; font-weight: 600; cursor: pointer; text-decoration: none; border: none; transition: background 0.15s; }
.btn-primary { background: #1a73e8; color: #fff; }
.btn-primary:hover { background: #1558c0; }
.btn-secondary { background: #e8f0fe; color: #1a73e8; }
.btn-secondary:hover { background: #d2e3fc; }
.btn-danger { background: #fce8e6; color: #c5221f; }
.btn-danger:hover { background: #f5c6c4; }
.btn-sm { padding: 0.3rem 0.75rem; font-size: 0.82rem; }
.card { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(26,115,232,0.07); padding: 2rem; margin-bottom: 1.5rem; }
.detail-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem; }
.detail-item label { font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.06em; color: #9aa0a6; font-weight: 600; }
.detail-item p { margin: 0.25rem 0 0; font-size: 0.95rem; color: #0b2545; font-weight: 500; }
.section-title { color: #0b2545; font-size: 1.05rem; font-weight: 700; margin: 0 0 1.25rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e8f0fe; }
.badge { display: inline-block; padding: 0.25rem 0.65rem; border-radius: 20px; font-size: 0.78rem; font-weight: 600; }
.badge-operationnel { background: #e6f4ea; color: #1e7e34; }
.badge-maintenance { background: #fef3cd; color: #856404; }
.badge-hors_service { background: #fce8e6; color: #c5221f; }
.badge-planifiee { background: #e8f0fe; color: #1a73e8; }
.badge-en_cours { background: #fef3cd; color: #856404; }
.badge-terminee { background: #e6f4ea; color: #1e7e34; }
.badge-annulee { background: #f1f3f4; color: #5f6368; }
table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
thead th { background: #f4f8fb; color: #5f6368; font-weight: 600; padding: 0.8rem 1rem; text-align: left; white-space: nowrap; }
tbody tr { border-top: 1px solid #f0f4f8; }
tbody tr:hover { background: #f8faff; }
tbody td { padding: 0.75rem 1rem; color: #3c4043; }
.actions { display: flex; gap: 0.4rem; }
.empty-state { text-align: center; padding: 2.5rem; color: #9aa0a6; }
</style>

<div class="crud-page">
    <div class="crud-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.infrastructure.infrastructures.index') }}">Infrastructures</a> / {{ $infrastructure->nom }}
            </div>
            <h1>{{ $infrastructure->nom }}</h1>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.infrastructure.infrastructures.edit', $infrastructure) }}" class="btn btn-primary">Modifier</a>
            <form method="POST" action="{{ route('admin.infrastructure.infrastructures.destroy', $infrastructure) }}" onsubmit="return confirm('Supprimer cette infrastructure ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Supprimer</button>
            </form>
            <a href="{{ route('admin.infrastructure.infrastructures.index') }}" class="btn btn-secondary">← Retour</a>
        </div>
    </div>

    <div class="card">
        <p class="section-title">Détails de l'infrastructure</p>
        <div class="detail-grid">
            <div class="detail-item">
                <label>Nom</label>
                <p>{{ $infrastructure->nom }}</p>
            </div>
            <div class="detail-item">
                <label>Type</label>
                <p>{{ ucfirst(str_replace('_', ' ', $infrastructure->type)) }}</p>
            </div>
            <div class="detail-item">
                <label>Matériau</label>
                <p>{{ $infrastructure->materiau }}</p>
            </div>
            <div class="detail-item">
                <label>Zone</label>
                <p>
                    @if($infrastructure->zone)
                        <a href="{{ route('admin.infrastructure.zones.show', $infrastructure->zone) }}" style="color:#1a73e8; text-decoration:none;">
                            {{ $infrastructure->zone->nom }}
                        </a>
                    @else
                        –
                    @endif
                </p>
            </div>
            <div class="detail-item">
                <label>Date d'installation</label>
                <p>{{ $infrastructure->date_installation?->format('d/m/Y') ?? '–' }}</p>
            </div>
            <div class="detail-item">
                <label>Capacité</label>
                <p>{{ number_format($infrastructure->capacite, 2, ',', ' ') }} m³</p>
            </div>
            <div class="detail-item">
                <label>Statut</label>
                <p>
                    <span class="badge badge-{{ $infrastructure->statut }}">
                        {{ match($infrastructure->statut) {
                            'operationnel' => 'Opérationnel',
                            'maintenance' => 'Maintenance',
                            'hors_service' => 'Hors service',
                            default => $infrastructure->statut
                        } }}
                    </span>
                </p>
            </div>
            <div class="detail-item">
                <label>Score de risque</label>
                <p>{{ $infrastructure->score_risque !== null ? $infrastructure->score_risque . ' / 100' : '–' }}</p>
            </div>
            <div class="detail-item">
                <label>Latitude</label>
                <p>{{ $infrastructure->latitude }}</p>
            </div>
            <div class="detail-item">
                <label>Longitude</label>
                <p>{{ $infrastructure->longitude }}</p>
            </div>
            <div class="detail-item">
                <label>Créée le</label>
                <p>{{ $infrastructure->created_at->format('d/m/Y à H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem;">
            <p class="section-title" style="margin:0; border:none;">Historique des maintenances ({{ $infrastructure->maintenances->count() }})</p>
            <a href="{{ route('admin.infrastructure.maintenances.create') }}?infrastructure_id={{ $infrastructure->id }}" class="btn btn-primary btn-sm">+ Nouvelle maintenance</a>
        </div>

        @if($infrastructure->maintenances->isEmpty())
            <div class="empty-state">🔧 Aucune maintenance enregistrée.</div>
        @else
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Technicien</th>
                            <th>Date</th>
                            <th>Coût</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($infrastructure->maintenances as $m)
                            <tr>
                                <td>{{ ucfirst($m->type) }}</td>
                                <td>{{ $m->technicien?->name ?? '–' }}</td>
                                <td>{{ $m->date_intervention?->format('d/m/Y') ?? '–' }}</td>
                                <td>{{ number_format($m->cout, 2, ',', ' ') }} DA</td>
                                <td>
                                    <span class="badge badge-{{ $m->statut }}">
                                        {{ match($m->statut) {
                                            'planifiee' => 'Planifiée',
                                            'en_cours' => 'En cours',
                                            'terminee' => 'Terminée',
                                            'annulee' => 'Annulée',
                                            default => $m->statut
                                        } }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.infrastructure.maintenances.show', $m) }}" class="btn btn-secondary btn-sm">Voir</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

</x-admin-layout>
