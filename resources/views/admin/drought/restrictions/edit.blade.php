@extends('layouts.app')

@section('content')
<div class="aq-drought-container" style="max-width: 700px;">
    <h1 style="color: var(--navy); margin-bottom: 2rem;">Éditer la Restriction</h1>

    <form method="POST" action="{{ route('admin.drought.restrictions.update', $restriction) }}" class="aq-card">
        @csrf
        @method('PUT')

        <div class="aq-form-group">
            <label for="titre">Titre *</label>
            <input type="text" id="titre" name="titre" value="{{ old('titre', $restriction->titre) }}" required>
            @error('titre')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="aq-form-group">
            <label for="zone_id">Zone *</label>
            <select id="zone_id" name="zone_id" required>
                @foreach($zones as $zone)
                    <option value="{{ $zone->id }}" {{ old('zone_id', $restriction->zone_id) == $zone->id ? 'selected' : '' }}>
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
                <option value="vigilance" {{ old('niveau', $restriction->niveau) == 'vigilance' ? 'selected' : '' }}>🟡 Vigilance</option>
                <option value="alerte" {{ old('niveau', $restriction->niveau) == 'alerte' ? 'selected' : '' }}>🟠 Alerte</option>
                <option value="crise" {{ old('niveau', $restriction->niveau) == 'crise' ? 'selected' : '' }}>🔴 Crise</option>
            </select>
            @error('niveau')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="aq-form-group">
            <label for="description">Description *</label>
            <textarea id="description" name="description" required>{{ old('description', $restriction->description) }}</textarea>
            @error('description')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="aq-form-group">
            <label for="date_debut">Date de Début *</label>
            <input type="datetime-local" id="date_debut" name="date_debut" value="{{ old('date_debut', $restriction->date_debut->format('Y-m-d H:i')) }}" required>
            @error('date_debut')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="aq-form-group">
            <label for="date_fin">Date de Fin (optionnel)</label>
            <input type="datetime-local" id="date_fin" name="date_fin" value="{{ old('date_fin', $restriction->date_fin ? $restriction->date_fin->format('Y-m-d H:i') : '') }}">
            @error('date_fin')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="aq-btn aq-btn-success">Mettre à jour</button>
            <a href="{{ route('admin.drought.restrictions.index') }}" class="aq-btn aq-btn-secondary">← Annuler</a>
        </div>
    </form>
</div>
@endsection
