@extends('layouts.app')

@section('content')
<style>{!! file_get_contents(resource_path('views/components/drought/drought.css')) !!}</style>

<div class="aq-drought-container" style="max-width: 600px;">
    <div class="aq-drought-header">
        <h1>{{ $restriction->titre }}</h1>
    </div>

    <div class="aq-card">
        <p><strong>Zone:</strong> {{ $restriction->zone->nom }}</p>
        <p><strong>Niveau:</strong> <span class="aq-badge aq-badge-{{ $restriction->niveau }}">{{ ucfirst($restriction->niveau) }}</span></p>
        <p><strong>Début:</strong> {{ $restriction->date_debut->format('d/m/Y H:i') }}</p>
        <p><strong>Fin:</strong> {{ $restriction->date_fin ? $restriction->date_fin->format('d/m/Y H:i') : '-' }}</p>
        <p><strong>Créateur:</strong> {{ $restriction->createur->name }}</p>
        <p><strong>Description:</strong></p>
        <p>{{ $restriction->description }}</p>

        @if($restriction->cuts->count())
            <h3>Coupures Planifiées</h3>
            <table class="aq-table">
                <thead>
                    <tr>
                        <th>Zone</th>
                        <th>Début</th>
                        <th>Fin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($restriction->cuts as $cut)
                        <tr>
                            <td>{{ $cut->zone->nom }}</td>
                            <td>{{ $cut->debut->format('d/m/Y H:i') }}</td>
                            <td>{{ $cut->fin->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div style="display: flex; gap: 1rem;">
        <a href="{{ route('admin.drought.restrictions.edit', $restriction) }}" class="aq-btn aq-btn-info">Éditer</a>
        <a href="{{ route('admin.drought.restrictions.index') }}" class="aq-btn aq-btn-secondary">Retour</a>
    </div>
</div>
@endsection
