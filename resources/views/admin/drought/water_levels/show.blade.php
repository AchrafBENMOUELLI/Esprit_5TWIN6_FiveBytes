@extends('layouts.app')

@section('content')
<style>{!! file_get_contents(resource_path('views/components/drought/drought.css')) !!}</style>

<div class="aq-drought-container" style="max-width: 600px;">
    <div class="aq-drought-header">
        <h1>Niveau d'Eau - {{ $waterLevel->zone->nom }}</h1>
    </div>

    <div class="aq-card">
        <p><strong>Zone:</strong> {{ $waterLevel->zone->nom }}</p>
        <p><strong>Source:</strong> {{ ucfirst($waterLevel->source) }}</p>
        <p><strong>Niveau:</strong> {{ number_format($waterLevel->niveau_pourcentage, 1) }}%</p>
        <p><strong>Volume:</strong> {{ number_format($waterLevel->volume_m3, 0, ',', ' ') }} m³</p>
        <p><strong>Date du Relevé:</strong> {{ $waterLevel->date_releve->format('d/m/Y H:i') }}</p>
    </div>

    <div style="display: flex; gap: 1rem;">
        <a href="{{ route('admin.drought.water-levels.edit', $waterLevel) }}" class="aq-btn aq-btn-info">Éditer</a>
        <a href="{{ route('admin.drought.water-levels.index') }}" class="aq-btn aq-btn-secondary">Retour</a>
    </div>
</div>
@endsection
