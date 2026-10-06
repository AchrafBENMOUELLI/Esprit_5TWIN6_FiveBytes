@extends('layouts.app')

@section('content')
<style>{!! file_get_contents(resource_path('views/components/drought/drought.css')) !!}</style>

<div class="aq-drought-container">
    <div class="aq-drought-header">
        <h1>{{ $zone->nom }} - Alertes</h1>
        <p>Restrictions actuelles et coupures planifiées</p>
    </div>

    <h2 style="color: var(--navy); margin-top: 2rem;">Restrictions Actuelles</h2>
    @if($restrictions->count())
        @foreach($restrictions as $restriction)
            <div class="aq-card">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3>{{ $restriction->titre }}</h3>
                        <p class="aq-badge aq-badge-{{ $restriction->niveau }}">
                            {{ ucfirst($restriction->niveau) }}
                        </p>
                    </div>
                </div>
                <p><strong>Description:</strong> {{ $restriction->description }}</p>
                <p><strong>Début:</strong> {{ $restriction->date_debut->format('d/m/Y H:i') }}</p>
                @if($restriction->date_fin)
                    <p><strong>Fin:</strong> {{ $restriction->date_fin->format('d/m/Y H:i') }}</p>
                @endif
            </div>
        @endforeach
    @else
        <div class="aq-card">
            <p style="text-align: center; color: var(--muted);">Aucune restriction active.</p>
        </div>
    @endif

    <h2 style="color: var(--navy); margin-top: 2rem;">Coupures Planifiées</h2>
    @if($scheduledCuts->count())
        <table class="aq-table">
            <thead>
                <tr>
                    <th>Restriction</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Motif</th>
                </tr>
            </thead>
            <tbody>
                @foreach($scheduledCuts as $cut)
                    <tr>
                        <td><strong>{{ $cut->restriction->titre }}</strong></td>
                        <td>{{ $cut->debut->format('d/m/Y H:i') }}</td>
                        <td>{{ $cut->fin->format('d/m/Y H:i') }}</td>
                        <td>{{ $cut->motif ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="aq-card">
            <p style="text-align: center; color: var(--muted);">Aucune coupure planifiée pour cette zone.</p>
        </div>
    @endif

    <div style="margin-top: 2rem;">
        <a href="{{ route('dashboard', ['module' => 'drought']) }}" class="aq-btn aq-btn-secondary">← Retour</a>
        <a href="{{ route('front.drought.subscriptions') }}" class="aq-btn aq-btn-info">S'abonner aux alertes</a>
    </div>
</div>
@endsection
