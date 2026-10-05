<x-admin-layout>
<style>
.crud-page { font-family: 'Segoe UI', sans-serif; }
.crud-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
.crud-header h1 { color: #0b2545; font-size: 1.4rem; margin: 0; }
.breadcrumb { color: #64748b; font-size: 0.85rem; }
.breadcrumb a { color: #1a73e8; text-decoration: none; }
.breadcrumb a:hover { text-decoration: underline; }
.card { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(26,115,232,0.07); padding: 2rem; }
.form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.25rem; }
.form-group { display: flex; flex-direction: column; gap: 0.4rem; }
.form-group label { font-size: 0.88rem; font-weight: 600; color: #3c4043; }
.form-group input, .form-group select, .form-group textarea {
    padding: 0.55rem 0.85rem;
    border: 1.5px solid #d1d9e0;
    border-radius: 8px;
    font-size: 0.9rem;
    outline: none;
    background: #fff;
    transition: border-color 0.15s;
}
.form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #1a73e8; }
.form-group .error-msg { font-size: 0.8rem; color: #c5221f; }
.form-group input.is-invalid, .form-group select.is-invalid, .form-group textarea.is-invalid { border-color: #ea4335; }
.form-actions { display: flex; gap: 0.75rem; margin-top: 1.75rem; }
.btn { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.55rem 1.25rem; border-radius: 8px; font-size: 0.9rem; font-weight: 600; cursor: pointer; text-decoration: none; border: none; transition: background 0.15s; }
.btn-primary { background: #1a73e8; color: #fff; }
.btn-primary:hover { background: #1558c0; }
.btn-secondary { background: #e8f0fe; color: #1a73e8; }
.btn-secondary:hover { background: #d2e3fc; }
.section-divider { color: #0b2545; font-size: 1rem; font-weight: 600; margin: 1.5rem 0 0.75rem; padding-bottom: 0.4rem; border-bottom: 2px solid #e8f0fe; grid-column: 1 / -1; }
</style>

<div class="crud-page">
    <div class="crud-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.infrastructure.zones.index') }}">Zones</a> /
                <a href="{{ route('admin.infrastructure.zones.show', $zone) }}">{{ $zone->nom }}</a> /
                Modifier
            </div>
            <h1>Modifier la zone : {{ $zone->nom }}</h1>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('admin.infrastructure.zones.update', $zone) }}">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <p class="section-divider">Informations générales</p>

                <div class="form-group">
                    <label for="nom">Nom <span style="color:#ea4335">*</span></label>
                    <input type="text" id="nom" name="nom" value="{{ old('nom', $zone->nom) }}" class="{{ $errors->has('nom') ? 'is-invalid' : '' }}" placeholder="Nom de la zone">
                    @error('nom')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="commune">Commune <span style="color:#ea4335">*</span></label>
                    <input type="text" id="commune" name="commune" value="{{ old('commune', $zone->commune) }}" class="{{ $errors->has('commune') ? 'is-invalid' : '' }}" placeholder="Nom de la commune">
                    @error('commune')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="code_postal">Code Postal <span style="color:#ea4335">*</span></label>
                    <input type="text" id="code_postal" name="code_postal" value="{{ old('code_postal', $zone->code_postal) }}" class="{{ $errors->has('code_postal') ? 'is-invalid' : '' }}" placeholder="Ex: 16000">
                    @error('code_postal')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="population">Population <span style="color:#ea4335">*</span></label>
                    <input type="number" id="population" name="population" value="{{ old('population', $zone->population) }}" class="{{ $errors->has('population') ? 'is-invalid' : '' }}" min="0" placeholder="Nombre d'habitants">
                    @error('population')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <p class="section-divider">Coordonnées géographiques</p>

                <div class="form-group">
                    <label for="latitude">Latitude <span style="color:#ea4335">*</span></label>
                    <input type="number" step="0.0000001" id="latitude" name="latitude" value="{{ old('latitude', $zone->latitude) }}" class="{{ $errors->has('latitude') ? 'is-invalid' : '' }}" placeholder="Ex: 36.7372">
                    @error('latitude')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="longitude">Longitude <span style="color:#ea4335">*</span></label>
                    <input type="number" step="0.0000001" id="longitude" name="longitude" value="{{ old('longitude', $zone->longitude) }}" class="{{ $errors->has('longitude') ? 'is-invalid' : '' }}" placeholder="Ex: 3.0869">
                    @error('longitude')<span class="error-msg">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('admin.infrastructure.zones.show', $zone) }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
</x-admin-layout>
