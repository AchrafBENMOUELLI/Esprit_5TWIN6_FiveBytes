<x-admin-layout>
<style>
.crud-page { font-family: 'Segoe UI', sans-serif; }
.crud-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; }
.crud-header h1 { color: #0b2545; font-size: 1.4rem; margin: 0; }
.btn { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1.1rem; border-radius: 8px; font-size: 0.9rem; font-weight: 600; cursor: pointer; text-decoration: none; border: none; transition: background 0.15s, box-shadow 0.15s; }
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
.search-bar { display: flex; gap: 0.6rem; margin-bottom: 1.25rem; }
.search-bar input { flex: 1; padding: 0.5rem 0.9rem; border: 1.5px solid #d1d9e0; border-radius: 8px; font-size: 0.9rem; outline: none; }
.search-bar input:focus { border-color: #1a73e8; }
.card { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(26,115,232,0.07); overflow: hidden; }
.table-wrap { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
thead th { background: #f4f8fb; color: #5f6368; font-weight: 600; padding: 0.85rem 1rem; text-align: left; white-space: nowrap; }
tbody tr { border-top: 1px solid #f0f4f8; }
tbody tr:hover { background: #f8faff; }
tbody td { padding: 0.8rem 1rem; color: #3c4043; vertical-align: middle; }
.actions { display: flex; gap: 0.4rem; }
.pagination-wrap { padding: 1rem 1rem 0.5rem; display: flex; justify-content: flex-end; }
.empty-state { text-align: center; padding: 3rem; color: #9aa0a6; }
.empty-state span { font-size: 2.5rem; display: block; margin-bottom: 0.5rem; }
</style>

<div class="crud-page">
    <div class="crud-header">
        <h1>🗺️ Zones</h1>
        <a href="{{ route('admin.infrastructure.zones.create') }}" class="btn btn-primary">+ Ajouter une zone</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <form method="GET" action="{{ route('admin.infrastructure.zones.index') }}" class="search-bar">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par nom, commune ou code postal…">
        <button type="submit" class="btn btn-secondary">Rechercher</button>
        @if(request('search'))
            <a href="{{ route('admin.infrastructure.zones.index') }}" class="btn btn-secondary">Effacer</a>
        @endif
    </form>

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Commune</th>
                        <th>Code Postal</th>
                        <th>Population</th>
                        <th>Infrastructures</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($zones as $zone)
                        <tr>
                            <td>{{ $zone->id }}</td>
                            <td><strong>{{ $zone->nom }}</strong></td>
                            <td>{{ $zone->commune }}</td>
                            <td>{{ $zone->code_postal }}</td>
                            <td>{{ number_format($zone->population, 0, ',', ' ') }}</td>
                            <td>{{ $zone->infrastructures_count ?? $zone->infrastructures()->count() }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.infrastructure.zones.show', $zone) }}" class="btn btn-secondary btn-sm">Voir</a>
                                    <a href="{{ route('admin.infrastructure.zones.edit', $zone) }}" class="btn btn-secondary btn-sm">Modifier</a>
                                    <form method="POST" action="{{ route('admin.infrastructure.zones.destroy', $zone) }}" onsubmit="return confirm('Supprimer cette zone ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <span>🗺️</span>
                                    Aucune zone trouvée.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($zones->hasPages())
            <div class="pagination-wrap">
                {{ $zones->links() }}
            </div>
        @endif
    </div>
</div>
</x-admin-layout>
