@extends('layouts.app')

@section('content')
<style>{!! file_get_contents(resource_path('views/components/drought/drought.css')) !!}</style>

<div class="aq-drought-container">
    <div class="aq-drought-header">
        <h1>Restrictions</h1>
        <p>Gérer les niveaux de restriction</p>
    </div>

    @if($message = session('success'))
        <div class="aq-alert aq-alert-success">{{ $message }}</div>
    @endif

    <a href="{{ route('admin.drought.restrictions.create') }}" class="aq-btn aq-btn-primary" style="margin-bottom: 1.5rem;">
        + Créer une restriction
    </a>

    @if($restrictions->count())
        <table class="aq-table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Zone</th>
                    <th>Niveau</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Créateur</th>
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
                        <td>{{ $restriction->date_fin ? $restriction->date_fin->format('d/m/Y H:i') : '-' }}</td>
                        <td>{{ $restriction->createur->name }}</td>
                        <td>
                            <a href="{{ route('admin.drought.restrictions.show', $restriction) }}" class="aq-btn" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Voir</a>
                            <a href="{{ route('admin.drought.restrictions.edit', $restriction) }}" class="aq-btn aq-btn-info" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Éditer</a>
                            <form method="POST" action="{{ route('admin.drought.restrictions.destroy', $restriction) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="aq-btn aq-btn-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem;" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $restrictions->links() }}
    @else
        <div class="aq-card">
            <p style="text-align: center; color: var(--muted);">Aucune restriction enregistrée.</p>
        </div>
    @endif
</div>
@endsection
