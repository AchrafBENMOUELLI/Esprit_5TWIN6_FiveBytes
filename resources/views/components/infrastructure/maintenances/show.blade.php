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
.card { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(26,115,232,0.07); padding: 2rem; margin-bottom: 1.5rem; }
.detail-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem; }
.detail-item label { font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.06em; color: #9aa0a6; font-weight: 600; }
.detail-item p { margin: 0.25rem 0 0; font-size: 0.95rem; color: #0b2545; font-weight: 500; }
.detail-item.full { grid-column: 1 / -1; }
.detail-item .desc-text { background: #f4f8fb; border-radius: 8px; padding: 0.85rem 1rem; font-size: 0.92rem; color: #3c4043; line-height: 1.6; white-space: pre-wrap; margin-top: 0.4rem; font-weight: normal; }
.section-title { color: #0b2545; font-size: 1.05rem; font-weight: 700; margin: 0 0 1.25rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e8f0fe; }
.badge { display: inline-block; padding: 0.28rem 0.7rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
.badge-planifiee { background: #e8f0fe; color: #1a73e8; }
.badge-en_cours { background: #fef3cd; color: #856404; }
.badge-terminee { background: #e6f4ea; color: #1e7e34; }
.badge-annulee { background: #f1f3f4; color: #5f6368; }
.badge-preventive { background: #e8f0fe; color: #1a73e8; }
.badge-corrective { background: #fef3cd; color: #856404; }
.badge-urgence { background: #fce8e6; color: #c5221f; }
</style>

<div class="crud-page">
    <div class="crud-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.infrastructure.maintenances.index') }}">Maintenances</a> / #{{ $maintenance->id }}
            </div>
            <h1>Maintenance #{{ $maintenance->id }}</h1>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.infrastructure.maintenances.edit', $maintenance) }}" class="btn btn-primary">Modifier</a>
            <form method="POST" action="{{ route('admin.infrastructure.maintenances.destroy', $maintenance) }}" onsubmit="return confirm('Supprimer cette maintenance ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Supprimer</button>
            </form>
            <a href="{{ route('admin.infrastructure.maintenances.index') }}" class="btn btn-secondary">← Retour</a>
        </div>
    </div>

    <div class="card">
        <p class="section-title">Détails de la maintenance</p>
        <div class="detail-grid">
            <div class="detail-item">
                <label>Infrastructure</label>
                <p>
                    @if($maintenance->infrastructure)
                        <a href="{{ route('admin.infrastructure.infrastructures.show', $maintenance->infrastructure) }}" style="color:#1a73e8; text-decoration:none;">
                            {{ $maintenance->infrastructure->nom }}
                        </a>
                    @else
                        –
                    @endif
                </p>
            </div>

            <div class="detail-item">
                <label>Zone</label>
                <p>{{ $maintenance->infrastructure?->zone?->nom ?? '–' }}</p>
            </div>

            <div class="detail-item">
                <label>Technicien</label>
                <p>{{ $maintenance->technicien?->name ?? '–' }}</p>
            </div>

            <div class="detail-item">
                <label>Type</label>
                <p>
                    <span class="badge badge-{{ $maintenance->type }}">
                        {{ match($maintenance->type) {
                            'preventive' => 'Préventive',
                            'corrective' => 'Corrective',
                            'urgence' => 'Urgence',
                            default => $maintenance->type
                        } }}
                    </span>
                </p>
            </div>

            <div class="detail-item">
                <label>Statut</label>
                <p>
                    <span class="badge badge-{{ $maintenance->statut }}">
                        {{ match($maintenance->statut) {
                            'planifiee' => 'Planifiée',
                            'en_cours' => 'En cours',
                            'terminee' => 'Terminée',
                            'annulee' => 'Annulée',
                            default => $maintenance->statut
                        } }}
                    </span>
                </p>
            </div>

            <div class="detail-item">
                <label>Date d'intervention</label>
                <p>{{ $maintenance->date_intervention?->format('d/m/Y') ?? '–' }}</p>
            </div>

            <div class="detail-item">
                <label>Coût</label>
                <p>{{ number_format($maintenance->cout, 2, ',', ' ') }} DA</p>
            </div>

            <div class="detail-item">
                <label>Enregistrée le</label>
                <p>{{ $maintenance->created_at->format('d/m/Y à H:i') }}</p>
            </div>

            <div class="detail-item full">
                <label>Description</label>
                <div class="desc-text">{{ $maintenance->description }}</div>
            </div>
        </div>
    </div>
</div>

</x-admin-layout>
