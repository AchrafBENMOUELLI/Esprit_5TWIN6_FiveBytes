@extends('layouts.app')

@section('content')
<style>{!! file_get_contents(resource_path('views/components/drought/drought.css')) !!}</style>

<div class="aq-drought-container" style="max-width: 600px;">
    <div class="aq-drought-header">
        <h1>Coupure Planifiée</h1>
    </div>

    <div class="aq-card">
        <p><strong>Restriction:</strong> {{ $cut->restriction->titre }}</p>
        <p><strong>Zone:</strong> {{ $cut->zone->nom }}</p>
        <p><strong>Début:</strong> {{ $cut->debut->format('d/m/Y H:i') }}</p>
        <p><strong>Fin:</strong> {{ $cut->fin->format('d/m/Y H:i') }}</p>
        <p><strong>Durée:</strong> {{ $cut->debut->diff($cut->fin)->format('%H:%I') }}</p>
        <p><strong>Motif:</strong></p>
        <p>{{ $cut->motif }}</p>
    </div>

    <div style="display: flex; gap: 1rem;">
        <a href="{{ route('admin.drought.scheduled-cuts.edit', $cut) }}" class="aq-btn aq-btn-info">Éditer</a>
        <a href="{{ route('admin.drought.scheduled-cuts.index') }}" class="aq-btn aq-btn-secondary">Retour</a>
    </div>
</div>
@endsection
