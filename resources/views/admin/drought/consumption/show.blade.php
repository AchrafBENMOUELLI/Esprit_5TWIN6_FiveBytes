@extends('layouts.app')

@section('content')
<style>{!! file_get_contents(resource_path('views/components/drought/drought.css')) !!}</style>

<div class="aq-drought-container" style="max-width: 600px;">
    <div class="aq-drought-header">
        <h1>Lecture de Consommation</h1>
    </div>

    <div class="aq-card">
        <p><strong>Zone:</strong> {{ $consumption->zone->nom }}</p>
        <p><strong>Volume:</strong> {{ number_format($consumption->volume_m3, 0, ',', ' ') }} m³</p>
        <p><strong>Période Début:</strong> {{ $consumption->periode_debut->format('d/m/Y H:i') }}</p>
        <p><strong>Période Fin:</strong> {{ $consumption->periode_fin->format('d/m/Y H:i') }}</p>
        <p><strong>Prévision IA:</strong></p>
        <p>{{ $consumption->prevision_ia }}</p>
    </div>

    <div style="display: flex; gap: 1rem;">
        <a href="{{ route('admin.drought.consumption.edit', $consumption) }}" class="aq-btn aq-btn-info">Éditer</a>
        <a href="{{ route('admin.drought.consumption.index') }}" class="aq-btn aq-btn-secondary">Retour</a>
    </div>
</div>
@endsection
