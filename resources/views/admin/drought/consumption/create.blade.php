@extends('layouts.app')

@section('content')
<style>{!! file_get_contents(resource_path('views/components/drought/drought.css')) !!}</style>

<div class="aq-drought-container" style="max-width: 600px;">
    <div class="aq-drought-header">
        <h1>Enregistrer une Lecture</h1>
    </div>

    <form method="POST" action="{{ route('admin.drought.consumption.store') }}" class="aq-card">
        @csrf

        <div class="aq-form-group">
            <label for="zone_id">Zone *</label>
            <select id="zone_id" name="zone_id" required>
                <option value="">-- Sélectionner une zone --</option>
                @foreach($zones as $zone)
                    <option value="{{ $zone->id }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>
                        {{ $zone->nom }}
                    </option>
                @endforeach
            </select>
            @error('zone_id')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="aq-form-group">
            <label for="volume_m3">Volume (m³) *</label>
            <input type="number" id="volume_m3" name="volume_m3" step="0.01" min="0" value="{{ old('volume_m3') }}" required>
            @error('volume_m3')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="aq-form-group">
            <label for="periode_debut">Période Début *</label>
            <input type="datetime-local" id="periode_debut" name="periode_debut" value="{{ old('periode_debut') }}" required>
            @error('periode_debut')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="aq-form-group">
            <label for="periode_fin">Période Fin *</label>
            <input type="datetime-local" id="periode_fin" name="periode_fin" value="{{ old('periode_fin') }}" required>
            @error('periode_fin')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="aq-form-group">
            <label for="prevision_ia">Prévision IA</label>
            <textarea id="prevision_ia" name="prevision_ia">{{ old('prevision_ia') }}</textarea>
            @error('prevision_ia')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="aq-btn aq-btn-success">Enregistrer</button>
            <a href="{{ route('admin.drought.consumption.index') }}" class="aq-btn aq-btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection
