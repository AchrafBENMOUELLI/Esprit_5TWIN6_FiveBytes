@extends('layouts.app')

@section('content')
<style>{!! file_get_contents(resource_path('views/components/drought/drought.css')) !!}</style>

<div class="aq-drought-container" style="max-width: 600px;">
    <div class="aq-drought-header">
        <h1>Créer une Restriction</h1>
    </div>

    <form method="POST" action="{{ route('admin.drought.restrictions.store') }}" class="aq-card">
        @csrf

        <div class="aq-form-group">
            <label for="titre">Titre *</label>
            <input type="text" id="titre" name="titre" value="{{ old('titre') }}" required>
            @error('titre')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

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
            <label for="niveau">Niveau *</label>
            <select id="niveau" name="niveau" required>
                <option value="vigilance" {{ old('niveau') == 'vigilance' ? 'selected' : '' }}>Vigilance</option>
                <option value="alerte" {{ old('niveau') == 'alerte' ? 'selected' : '' }}>Alerte</option>
                <option value="crise" {{ old('niveau') == 'crise' ? 'selected' : '' }}>Crise</option>
            </select>
            @error('niveau')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="aq-form-group">
            <label for="description">Description *</label>
            <textarea id="description" name="description" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="aq-form-group">
            <label for="date_debut">Date de Début *</label>
            <input type="datetime-local" id="date_debut" name="date_debut" value="{{ old('date_debut') }}" required>
            @error('date_debut')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="aq-form-group">
            <label for="date_fin">Date de Fin</label>
            <input type="datetime-local" id="date_fin" name="date_fin" value="{{ old('date_fin') }}">
            @error('date_fin')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="aq-btn aq-btn-success">Créer</button>
            <a href="{{ route('admin.drought.restrictions.index') }}" class="aq-btn aq-btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection
