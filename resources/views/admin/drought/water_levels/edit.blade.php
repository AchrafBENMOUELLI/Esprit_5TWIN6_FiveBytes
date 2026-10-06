@extends('layouts.app')

@section('content')
<style>{!! file_get_contents(resource_path('views/components/drought/drought.css')) !!}</style>

<div class="aq-drought-container" style="max-width: 600px;">
    <div class="aq-drought-header">
        <h1>Éditer le Niveau d'Eau</h1>
    </div>

    <form method="POST" action="{{ route('admin.drought.water-levels.update', $waterLevel) }}" class="aq-card">
        @csrf
        @method('PUT')

        <div class="aq-form-group">
            <label for="zone_id">Zone *</label>
            <select id="zone_id" name="zone_id" required>
                @foreach($zones as $zone)
                    <option value="{{ $zone->id }}" {{ old('zone_id', $waterLevel->zone_id) == $zone->id ? 'selected' : '' }}>
                        {{ $zone->nom }}
                    </option>
                @endforeach
            </select>
            @error('zone_id')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="aq-form-group">
            <label for="source">Source *</label>
            <select id="source" name="source" required>
                <option value="reservoir" {{ old('source', $waterLevel->source) == 'reservoir' ? 'selected' : '' }}>Réservoir</option>
                <option value="nappe" {{ old('source', $waterLevel->source) == 'nappe' ? 'selected' : '' }}>Nappe</option>
                <option value="barrage" {{ old('source', $waterLevel->source) == 'barrage' ? 'selected' : '' }}>Barrage</option>
            </select>
            @error('source')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="aq-form-group">
            <label for="niveau_pourcentage">Niveau (%) *</label>
            <input type="number" id="niveau_pourcentage" name="niveau_pourcentage" step="0.01" min="0" max="100" value="{{ old('niveau_pourcentage', $waterLevel->niveau_pourcentage) }}" required>
            @error('niveau_pourcentage')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="aq-form-group">
            <label for="volume_m3">Volume (m³) *</label>
            <input type="number" id="volume_m3" name="volume_m3" step="0.01" min="0" value="{{ old('volume_m3', $waterLevel->volume_m3) }}" required>
            @error('volume_m3')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="aq-form-group">
            <label for="date_releve">Date du Relevé *</label>
            <input type="datetime-local" id="date_releve" name="date_releve" value="{{ old('date_releve', $waterLevel->date_releve->format('Y-m-d\TH:i')) }}" required>
            @error('date_releve')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="aq-btn aq-btn-success">Mettre à jour</button>
            <a href="{{ route('admin.drought.water-levels.index') }}" class="aq-btn aq-btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection
