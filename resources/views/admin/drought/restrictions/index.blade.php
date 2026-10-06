@extends('layouts.app')

@section('content')
<div class="aq-drought-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div class="aq-drought-header" style="margin: 0;">
            <h1>Restrictions d'Eau</h1>
            <p>Gérez les niveaux de restriction par zone</p>
        </div>
        <a href="{{ route('admin.drought.restrictions.create') }}" class="aq-btn aq-btn-primary">
            + Créer
        </a>
    </div>

    @if($restrictions->count())
        <div style="overflow-x: auto;">
            <table class="aq-table">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Zone</th>
                        <th>Niveau</th>
                        <th>Début</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($restrictions as $restriction)
                        <tr>
                            <td><strong>{{ $restriction->titre }}</strong></td>
                            <td>{{ $restriction->zone->nom }}</td>
                            <td>
                                <span class="aq-badge aq-badge-{{ $restriction->niveau }}">
                                    {{ ucfirst($restriction->niveau) }}
                                </span>
                            </td>
                            <td>{{ $restriction->date_debut->format('d/m/Y H:i') }}</td>
                            <td style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('admin.drought.restrictions.edit', $restriction) }}" class="aq-btn aq-btn-info" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Éditer</a>
                                <form method="POST" action="{{ route('admin.drought.restrictions.destroy', $restriction) }}" style="display: inline;" onsubmit="return confirm('Confirmer la suppression ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="aq-btn aq-btn-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 2rem;">
            {{ $restrictions->links() }}
        </div>
    @else
        <div class="aq-card">
            <p style="text-align: center; color: var(--muted);">Aucune restriction enregistrée.</p>
        </div>
    @endif

    <div style="margin-top: 2rem;">
        <a href="{{ route('drought.test') }}" class="aq-btn aq-btn-secondary">← Retour</a>
    </div>
</div>
@endsection
