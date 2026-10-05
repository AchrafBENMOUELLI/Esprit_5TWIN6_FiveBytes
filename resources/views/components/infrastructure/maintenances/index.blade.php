<x-admin-layout>
<style>
.crud-page { font-family: 'Segoe UI', sans-serif; }
.crud-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; }
.crud-header h1 { color: #0b2545; font-size: 1.4rem; margin: 0; }
.btn { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1.1rem; border-radius: 8px; font-size: 0.9rem; font-weight: 600; cursor: pointer; text-decoration: none; border: none; transition: background 0.15s; }
.btn-primary { background: #1a73e8; color: #fff; }
.btn-primary:hover { background: #1558c0; }
.btn-secondary { background: #e8f0fe; color: #1a73e8; }
.btn-secondary:hover { background: #d2e3fc; }
.btn-danger { background: #fce8e6; color: #c5221f; }
.btn-danger:hover { background: #f5c6c4; }
.btn-sm { padding: 0.3rem 0.75rem; font-size: 0.82rem; }
.alert { padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.25rem; font-size: 0.92rem; }
.alert-success { background: #e6f4ea; color: #1e7e34; border-left: 4px solid #34a853; }
.alert-error { background: #fce8e6; color: #c5221f; border-left: 4px solid #ea4335; }
.filter-bar { display: flex; gap: 0.6rem; margin-bottom: 1.25rem; flex-wrap: wrap; }
.filter-bar select { padding: 0.5rem 0.9rem; border: 1.5px solid #d1d9e0; border-radius: 8px; font-size: 0.9rem; outline: none; background: #fff; }
.filter-bar select:focus { border-color: #1a73e8; }
.card { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(26,115,232,0.07); overflow: hidden; }
.table-wrap { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
thead th { background: #f4f8fb; color: #5f6368; font-weight: 600; padding: 0.85rem 1rem; text-align: left; white-space: nowrap; }
tbody tr { border-top: 1px solid #f0f4f8; }
tbody tr:hover { background: #f8faff; }
tbody td { padding: 0.8rem 1rem; color: #3c4043; vertical-align: middle; }
.badge { display: inline-block; padding: 0.25rem 0.65rem; border-radius: 20px; font-size: 0.78rem; font-weight: 600; }
.badge-planifiee { background: #e8f0fe; color: #1a73e8; }
.badge-en_cours { background: #fef3cd; color: #856404; }
.badge-terminee { background: #e6f4ea; color: #1e7e34; }
.badge-annulee { background: #f1f3f4; color: #5f6368; }
.actions { display: flex; gap: 0.4rem; }
.pagination-wrap { padding: 1rem 1rem 0.5rem; display: flex; justify-content: flex-end; }
.empty-state { text-align: center; padding: 3rem; color: #9aa0a6; }
.empty-state span { font-size: 2.5rem; display: block; margin-bottom: 0.5rem; }
</style>

<div class="crud-page">
    <div class="crud-header">
        <h1>🔧 Maintenances</h1>
        <a href="{{ route('admin.infrastructure.maintenances.create') }}" class="btn btn-primary">+ Ajouter une maintenance</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <form method="GET" action="{{ route('admin.infrastructure.maintenances.index') }}" class="filter-bar">
        <select name="infrastructure_id">
            <option value="">Toutes les infrastructures</option>
            @foreach($infrastructures as $infra)
                <option value="{{ $infra->id }}" {{ request('infrastructure_id') == $infra->id ? 'selected' : '' }}>{{ $infra->nom }}</option>
            @endforeach
        </select>
        <select name="statut">
            <option value="">Tous les statuts</option>
            <option value="planifiee" {{ request('statut') === 'planifiee' ? 'selected' : '' }}>Planifiée</option>
            <option value="en_cours" {{ request('statut') === 'en_cours' ? 'selected' : '' }}>En cours</option>
            <option value="terminee" {{ request('statut') === 'terminee' ? 'selected' : '' }}>Terminée</option>
            <option value="annulee" {{ request('statut') === 'annulee' ? 'selected' : '' }}>Annulée</option>
        </select>
        <button type="submit" class="btn btn-secondary">Filtrer</button>
        @if(request()->hasAny(['infrastructure_id', 'statut']))
            <a href="{{ route('admin.infrastructure.maintenances.index') }}" class="btn btn-secondary">Effacer</a>
        @endif
    </form>

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Infrastructure</th>
                        <th>Technicien</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Coût</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($maintenances as $m)
                        <tr>
                            <td>{{ $m->id }}</td>
                            <td>{{ $m->infrastructure?->nom ?? '–' }}</td>
                            <td>{{ $m->technicien?->name ?? '–' }}</td>
                            <td>{{ ucfirst($m->type) }}</td>
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
                                <div class="actions">
                                    <a href="{{ route('admin.infrastructure.maintenances.show', $m) }}" class="btn btn-secondary btn-sm">Voir</a>
                                    <a href="{{ route('admin.infrastructure.maintenances.edit', $m) }}" class="btn btn-secondary btn-sm">Modifier</a>
                                    <form method="POST" action="{{ route('admin.infrastructure.maintenances.destroy', $m) }}" onsubmit="return confirm('Supprimer cette maintenance ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <span>🔧</span>
                                    Aucune maintenance trouvée.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($maintenances->hasPages())
            <div class="pagination-wrap">
                {{ $maintenances->links() }}
            </div>
        @endif
    </div>
</div>
</x-admin-layout>
