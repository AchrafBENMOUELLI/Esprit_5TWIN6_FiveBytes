@extends('layouts.app')

@section('content')
<style>{!! file_get_contents(resource_path('views/components/drought/drought.css')) !!}</style>

<div class="aq-drought-container">
    <div class="aq-drought-header">
        <h1>Tableau de Bord - Sécheresse</h1>
        <p>Consultez le niveau d'alerte de votre zone</p>
    </div>

    @if($message = session('success'))
        <div class="aq-alert aq-alert-success">{{ $message }}</div>
    @endif
    @if($message = session('error'))
        <div class="aq-alert aq-alert-error">{{ $message }}</div>
    @endif

    <div class="aq-grid">
        @foreach($zones as $zone)
            <div class="aq-card">
                <h3>{{ $zone->nom }}</h3>
                <p><strong>Commune:</strong> {{ $zone->commune }}</p>
                <p><strong>Population:</strong> {{ number_format($zone->population, 0, ',', ' ') }}</p>
                
                @php
                    $restriction = $zone->restrictions()
                        ->where('date_fin', '>=', now())
                        ->orWhereNull('date_fin')
                        ->latest('date_debut')
                        ->first();
                @endphp

                @if($restriction)
                    <p>
                        <strong>Niveau d'Alerte:</strong><br>
                        <span class="aq-badge aq-badge-{{ $restriction->niveau }}">
                            {{ ucfirst($restriction->niveau) }}
                        </span>
                    </p>
                    <p><strong>Restriction:</strong> {{ $restriction->titre }}</p>
                @else
                    <p>
                        <strong>Niveau d'Alerte:</strong><br>
                        <span class="aq-badge aq-badge-vigilance">Normal</span>
                    </p>
                @endif

                <a href="{{ route('front.drought.zone.alerts', $zone) }}" class="aq-btn aq-btn-secondary" style="width: 100%; text-align: center; margin-top: 1rem;">
                    Voir les détails
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
