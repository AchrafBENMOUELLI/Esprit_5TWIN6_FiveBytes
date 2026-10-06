@extends('layouts.app')

@section('content')
<style>{!! file_get_contents(resource_path('views/components/drought/drought.css')) !!}</style>

<div class="aq-drought-container">
    <div class="aq-drought-header">
        <h1>Niveaux d'Eau</h1>
        <p>Suivi des réservoirs, nappes et barrages</p>
    </div>

    <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
        <a href="{{ route('admin.drought.water-levels.create') }}" class="aq-btn aq-btn-primary">
            + Enregistrer un niveau
        </a>
        <a href="{{ route('dashboard', ['module' => 'drought']) }}" class="aq-btn aq-btn-secondary">← Retour</a>
    </div>

    @if($waterLevels->count())
        <table class="aq-table">
            <thead>
                <tr>
                    <th>Zone</th>
                    <th>Source</th>
                    <th>Niveau %</th>
                    <th>Volume (m³)</th>
                    <th>Date du Relevé</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($waterLevels as $level)
                    <tr>
                        <td>{{ $level->zone->nom }}</td>
                        <td>{{ ucfirst($level->source) }}</td>
                        <td>
                            <strong>{{ number_format($level->niveau_pourcentage, 1) }}%</strong>
                        </td>
                        <td>{{ number_format($level->volume_m3, 0, ',', ' ') }}</td>
                        <td>{{ $level->date_releve->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.drought.water-levels.show', $level) }}" class="aq-btn" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Voir</a>
                            <a href="{{ route('admin.drought.water-levels.edit', $level) }}" class="aq-btn aq-btn-info" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Éditer</a>
                            <form method="POST" action="{{ route('admin.drought.water-levels.destroy', $level) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="aq-btn aq-btn-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem;" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $waterLevels->links() }}
    @else
        <div class="aq-card">
            <p style="text-align: center; color: var(--muted);">Aucun niveau d'eau enregistré.</p>
        </div>
    @endif
</div>
@endsection
