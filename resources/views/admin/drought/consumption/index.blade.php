@extends('layouts.app')

@section('content')
<style>{!! file_get_contents(resource_path('views/components/drought/drought.css')) !!}</style>

<div class="aq-drought-container">
    <div class="aq-drought-header">
        <h1>Lectures de Consommation</h1>
        <p>Suivi de la consommation d'eau par zone</p>
    </div>

    <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
        <a href="{{ route('admin.drought.consumption.create') }}" class="aq-btn aq-btn-primary">
            + Enregistrer une lecture
        </a>
        <a href="{{ route('dashboard', ['module' => 'drought']) }}" class="aq-btn aq-btn-secondary">← Retour</a>
    </div>

    @if($readings->count())
        <table class="aq-table">
            <thead>
                <tr>
                    <th>Zone</th>
                    <th>Volume (m³)</th>
                    <th>Période Début</th>
                    <th>Période Fin</th>
                    <th>Prévision IA</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($readings as $reading)
                    <tr>
                        <td>{{ $reading->zone->nom }}</td>
                        <td>{{ number_format($reading->volume_m3, 0, ',', ' ') }}</td>
                        <td>{{ $reading->periode_debut->format('d/m/Y') }}</td>
                        <td>{{ $reading->periode_fin->format('d/m/Y') }}</td>
                        <td>{{ Str::limit($reading->prevision_ia, 30) }}</td>
                        <td>
                            <a href="{{ route('admin.drought.consumption.show', $reading) }}" class="aq-btn" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Voir</a>
                            <a href="{{ route('admin.drought.consumption.edit', $reading) }}" class="aq-btn aq-btn-info" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Éditer</a>
                            <form method="POST" action="{{ route('admin.drought.consumption.destroy', $reading) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="aq-btn aq-btn-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem;" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $readings->links() }}
    @else
        <div class="aq-card">
            <p style="text-align: center; color: var(--muted);">Aucune lecture enregistrée.</p>
        </div>
    @endif
</div>
@endsection
