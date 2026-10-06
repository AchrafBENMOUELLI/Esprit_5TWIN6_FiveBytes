@extends('layouts.app')

@section('content')
<style>{!! file_get_contents(resource_path('views/components/drought/drought.css')) !!}</style>

<div class="aq-drought-container">
    <div class="aq-drought-header">
        <h1>Calendrier des Coupures</h1>
        <p>Prochaines interruptions d'eau programmées</p>
    </div>

    @if($cuts->count())
        <table class="aq-table">
            <thead>
                <tr>
                    <th>Zone</th>
                    <th>Restriction</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Durée</th>
                    <th>Motif</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cuts as $cut)
                    <tr>
                        <td><strong>{{ $cut->zone->nom }}</strong></td>
                        <td>{{ $cut->restriction->titre }}</td>
                        <td>{{ $cut->debut->format('d/m/Y H:i') }}</td>
                        <td>{{ $cut->fin->format('d/m/Y H:i') }}</td>
                        <td>{{ $cut->debut->diff($cut->fin)->format('%H:%I') }}</td>
                        <td>{{ $cut->motif ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $cuts->links() }}
    @else
        <div class="aq-card">
            <p style="text-align: center; color: var(--muted);">Aucune coupure planifiée pour le moment.</p>
        </div>
    @endif

    <div style="margin-top: 2rem;">
        <a href="{{ route('front.drought.dashboard') }}" class="aq-btn aq-btn-secondary">Retour</a>
    </div>
</div>
@endsection
