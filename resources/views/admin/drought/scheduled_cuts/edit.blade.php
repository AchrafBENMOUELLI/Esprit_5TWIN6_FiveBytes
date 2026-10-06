@extends('layouts.app')

@section('content')
<style>{!! file_get_contents(resource_path('views/components/drought/drought.css')) !!}</style>

<div class="aq-drought-container" style="max-width: 600px;">
    <div class="aq-drought-header">
        <h1>Éditer la Coupure</h1>
    </div>

    <form method="POST" action="{{ route('admin.drought.scheduled-cuts.update', $cut) }}" class="aq-card">
        @csrf
        @method('PUT')

        <div class="aq-form-group">
            <label for="restriction_id">Restriction *</label>
            <select id="restriction_id" name="restriction_id" required>
                @foreach($restrictions as $restriction)
                    <option value="{{ $restriction->id }}" {{ old('restriction_id', $cut->restriction_id) == $restriction->id ? 'selected' : '' }}>
                        {{ $restriction->titre }} - {{ $restriction->zone->nom }}
                    </option>
                @endforeach
            </select>
            @error('restriction_id')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="aq-form-group">
            <label for="zone_id">Zone *</label>
            <select id="zone_id" name="zone_id" required>
                @foreach($zones as $zone)
                    <option value="{{ $zone->id }}" {{ old('zone_id', $cut->zone_id) == $zone->id ? 'selected' : '' }}>
                        {{ $zone->nom }}
                    </option>
                @endforeach
            </select>
            @error('zone_id')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="aq-form-group">
            <label for="debut">Début *</label>
            <input type="datetime-local" id="debut" name="debut" value="{{ old('debut', $cut->debut->format('Y-m-d\TH:i')) }}" required>
            @error('debut')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="aq-form-group">
            <label for="fin">Fin *</label>
            <input type="datetime-local" id="fin" name="fin" value="{{ old('fin', $cut->fin->format('Y-m-d\TH:i')) }}" required>
            @error('fin')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="aq-form-group">
            <label for="motif">Motif</label>
            <textarea id="motif" name="motif">{{ old('motif', $cut->motif) }}</textarea>
            @error('motif')
                <div class="aq-error">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="aq-btn aq-btn-success">Mettre à jour</button>
            <a href="{{ route('admin.drought.scheduled-cuts.index') }}" class="aq-btn aq-btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection
