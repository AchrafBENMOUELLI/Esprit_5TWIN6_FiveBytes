@extends('layouts.app')

@section('content')
<style>{!! file_get_contents(resource_path('views/components/drought/drought.css')) !!}</style>

<div class="aq-drought-container">
    <div class="aq-drought-header">
        <h1>Coupures Planifiées</h1>
        <p>Calendrier des interruptions d'eau programmées</p>
    </div>

    <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
        <a href="{{ route('admin.drought.scheduled-cuts.create') }}" class="aq-btn aq-btn-primary">
            + Planifier une coupure
        </a>
        <a href="{{ route('drought.test') }}" class="aq-btn aq-btn-secondary">← Retour</a>
    </div>

    @if($cuts->count())
        <table class="aq-table">
            <thead>
                <tr>
                    <th>Restriction</th>
                    <th>Zone</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Durée</th>
                    <th>Motif</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cuts as $cut)
                    <tr>
                        <td>{{ $cut->restriction->titre }}</td>
                        <td>{{ $cut->zone->nom }}</td>
                        <td>{{ $cut->debut->format('d/m/Y H:i') }}</td>
                        <td>{{ $cut->fin->format('d/m/Y H:i') }}</td>
                        <td>{{ $cut->debut->diff($cut->fin)->format('%H:%I') }}</td>
                        <td>{{ Str::limit($cut->motif, 30) }}</td>
                        <td>
                            <a href="{{ route('admin.drought.scheduled-cuts.show', $cut) }}" class="aq-btn" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Voir</a>
                            <a href="{{ route('admin.drought.scheduled-cuts.edit', $cut) }}" class="aq-btn aq-btn-info" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Éditer</a>
                            <form method="POST" action="{{ route('admin.drought.scheduled-cuts.destroy', $cut) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="aq-btn aq-btn-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem;" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $cuts->links() }}
    @else
        <div class="aq-card">
            <p style="text-align: center; color: var(--muted);">Aucune coupure planifiée.</p>
        </div>
    @endif
</div>
@endsection
