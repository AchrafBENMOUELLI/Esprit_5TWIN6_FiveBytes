<x-admin-layout>
<style>
.crud-page { font-family: 'Segoe UI', sans-serif; }
.crud-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; }
.crud-header h1 { color: #0b2545; font-size: 1.4rem; margin: 0; }
.breadcrumb { color: #64748b; font-size: 0.85rem; margin-bottom: 0.25rem; }
.breadcrumb a { color: #1a73e8; text-decoration: none; }
.breadcrumb a:hover { text-decoration: underline; }
.header-actions { display: flex; gap: 0.6rem; }
.btn { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1.1rem; border-radius: 8px; font-size: 0.9rem; font-weight: 600; cursor: pointer; text-decoration: none; border: none; transition: background 0.15s; }
.btn-primary { background: #1a73e8; color: #fff; }
.btn-primary:hover { background: #1558c0; }
.btn-secondary { background: #e8f0fe; color: #1a73e8; }
.btn-secondary:hover { background: #d2e3fc; }
.btn-danger { background: #fce8e6; color: #c5221f; }
.btn-danger:hover { background: #f5c6c4; }
.btn-sm { padding: 0.3rem 0.75rem; font-size: 0.82rem; }
.card { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(26,115,232,0.07); padding: 2rem; margin-bottom: 1.5rem; }
.detail-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem; }
.detail-item label { font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.06em; color: #9aa0a6; font-weight: 600; }
.detail-item p { margin: 0.25rem 0 0; font-size: 0.95rem; color: #0b2545; font-weight: 500; }
.section-title { color: #0b2545; font-size: 1.05rem; font-weight: 700; margin: 0 0 1.25rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e8f0fe; }
table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
thead th { background: #f4f8fb; color: #5f6368; font-weight: 600; padding: 0.8rem 1rem; text-align: left; }
tbody tr { border-top: 1px solid #f0f4f8; }
tbody tr:hover { background: #f8faff; }
tbody td { padding: 0.75rem 1rem; color: #3c4043; }
.badge { display: inline-block; padding: 0.25rem 0.65rem; border-radius: 20px; font-size: 0.78rem; font-weight: 600; }
.badge-operationnel { background: #e6f4ea; color: #1e7e34; }
.badge-maintenance { background: #fef3cd; color: #856404; }
.badge-hors_service { background: #fce8e6; color: #c5221f; }
.empty-state { text-align: center; padding: 2.5rem; color: #9aa0a6; }
</style>

<div class="crud-page">
    <div class="crud-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.infrastructure.zones.index') }}">Zones</a> / {{ $zone->nom }}
            </div>
            <h1>{{ $zone->nom }}</h1>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.infrastructure.zones.edit', $zone) }}" class="btn btn-primary">Modifier</a>
            <form method="POST" action="{{ route('admin.infrastructure.zones.destroy', $zone) }}" onsubmit="return confirm('Supprimer cette zone et toutes ses infrastructures ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Supprimer</button>
            </form>
            <a href="{{ route('admin.infrastructure.zones.index') }}" class="btn btn-secondary">← Retour</a>
        </div>
    </div>

    <div class="card">
        <p class="section-title">Informations de la zone</p>
        <div class="detail-grid">
            <div class="detail-item">
                <label>Nom</label>
                <p>{{ $zone->nom }}</p>
            </div>
            <div class="detail-item">
                <label>Commune</label>
                <p>{{ $zone->commune }}</p>
            </div>
            <div class="detail-item">
                <label>Code Postal</label>
                <p>{{ $zone->code_postal }}</p>
            </div>
            <div class="detail-item">
                <label>Population</label>
                <p>{{ number_format($zone->population, 0, ',', ' ') }} habitants</p>
            </div>
            <div class="detail-item">
                <label>Latitude</label>
                <p>{{ $zone->latitude }}</p>
            </div>
            <div class="detail-item">
                <label>Longitude</label>
                <p>{{ $zone->longitude }}</p>
            </div>
            <div class="detail-item">
                <label>Créée le</label>
                <p>{{ $zone->created_at->format('d/m/Y à H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem;">
            <p class="section-title" style="margin:0; border:none;">Infrastructures de cette zone ({{ $zone->infrastructures->count() }})</p>
            <a href="{{ route('admin.infrastructure.infrastructures.create') }}?zone_id={{ $zone->id }}" class="btn btn-primary btn-sm">+ Ajouter</a>
        </div>

        @if($zone->infrastructures->isEmpty())
            <div class="empty-state">🏗️ Aucune infrastructure dans cette zone.</div>
        @else
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Type</th>
                            <th>Matériau</th>
                            <th>Statut</th>
                            <th>Score Risque</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($zone->infrastructures as $infra)
                            <tr>
                                <td><strong>{{ $infra->nom }}</strong></td>
                                <td>{{ ucfirst(str_replace('_', ' ', $infra->type)) }}</td>
                                <td>{{ $infra->materiau }}</td>
                                <td>
                                    <span class="badge badge-{{ $infra->statut }}">
                                        {{ match($infra->statut) {
                                            'operationnel' => 'Opérationnel',
                                            'maintenance' => 'Maintenance',
                                            'hors_service' => 'Hors service',
                                            default => $infra->statut
                                        } }}
                                    </span>
                                </td>
                                <td>{{ $infra->score_risque ?? '–' }}</td>
                                <td>
                                    <a href="{{ route('admin.infrastructure.infrastructures.show', $infra) }}" class="btn btn-secondary btn-sm">Voir</a>
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
