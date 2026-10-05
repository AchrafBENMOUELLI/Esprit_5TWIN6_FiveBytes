<x-admin-layout>
<style>
.crud-page { font-family: 'Segoe UI', sans-serif; }
.crud-header { margin-bottom: 1.5rem; }
.crud-header h1 { color: #0b2545; font-size: 1.4rem; margin: 0; }
.breadcrumb { color: #64748b; font-size: 0.85rem; margin-bottom: 0.25rem; }
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
.form-full { grid-column: 1 / -1; }
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
        <div class="breadcrumb">
            <a href="{{ route('admin.infrastructure.infrastructures.index') }}">Infrastructures</a> / Nouvelle infrastructure
        </div>
        <h1>Ajouter une infrastructure</h1>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('admin.infrastructure.infrastructures.store') }}">
            @csrf

            <div class="form-grid">
                <p class="section-divider">Informations générales</p>

                <div class="form-group">
                    <label for="nom">Nom <span style="color:#ea4335">*</span></label>
                    <input type="text" id="nom" name="nom" value="{{ old('nom') }}" class="{{ $errors->has('nom') ? 'is-invalid' : '' }}" placeholder="Nom de l'infrastructure">
                    @error('nom')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="type">Type <span style="color:#ea4335">*</span></label>
                    <select id="type" name="type" class="{{ $errors->has('type') ? 'is-invalid' : '' }}">
                        <option value="">-- Sélectionner un type --</option>
                        <option value="canalisation" {{ old('type') === 'canalisation' ? 'selected' : '' }}>Canalisation</option>
                        <option value="reservoir" {{ old('type') === 'reservoir' ? 'selected' : '' }}>Réservoir</option>
                        <option value="station_pompage" {{ old('type') === 'station_pompage' ? 'selected' : '' }}>Station de pompage</option>
                        <option value="captage" {{ old('type') === 'captage' ? 'selected' : '' }}>Captage</option>
                        <option value="compteur" {{ old('type') === 'compteur' ? 'selected' : '' }}>Compteur</option>
                    </select>
                    @error('type')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="materiau">Matériau <span style="color:#ea4335">*</span></label>
                    <input type="text" id="materiau" name="materiau" value="{{ old('materiau') }}" class="{{ $errors->has('materiau') ? 'is-invalid' : '' }}" placeholder="Ex: Acier, PVC, Béton">
                    @error('materiau')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="zone_id">Zone <span style="color:#ea4335">*</span></label>
                    <select id="zone_id" name="zone_id" class="{{ $errors->has('zone_id') ? 'is-invalid' : '' }}">
                        <option value="">-- Sélectionner une zone --</option>
                        @foreach($zones as $zone)
                            <option value="{{ $zone->id }}" {{ old('zone_id', request('zone_id')) == $zone->id ? 'selected' : '' }}>{{ $zone->nom }} – {{ $zone->commune }}</option>
                        @endforeach
                    </select>
                    @error('zone_id')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="date_installation">Date d'installation <span style="color:#ea4335">*</span></label>
                    <input type="date" id="date_installation" name="date_installation" value="{{ old('date_installation') }}" class="{{ $errors->has('date_installation') ? 'is-invalid' : '' }}" max="{{ date('Y-m-d') }}">
                    @error('date_installation')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="capacite">Capacité (m³) <span style="color:#ea4335">*</span></label>
                    <input type="number" step="0.01" id="capacite" name="capacite" value="{{ old('capacite') }}" class="{{ $errors->has('capacite') ? 'is-invalid' : '' }}" min="0" placeholder="0.00">
                    @error('capacite')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="statut">Statut <span style="color:#ea4335">*</span></label>
                    <select id="statut" name="statut" class="{{ $errors->has('statut') ? 'is-invalid' : '' }}">
                        <option value="">-- Sélectionner un statut --</option>
                        <option value="operationnel" {{ old('statut') === 'operationnel' ? 'selected' : '' }}>Opérationnel</option>
                        <option value="maintenance" {{ old('statut') === 'maintenance' ? 'selected' : '' }}>En maintenance</option>
                        <option value="hors_service" {{ old('statut') === 'hors_service' ? 'selected' : '' }}>Hors service</option>
                    </select>
                    @error('statut')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="score_risque">Score de risque (0–100)</label>
                    <input type="number" step="0.01" id="score_risque" name="score_risque" value="{{ old('score_risque') }}" class="{{ $errors->has('score_risque') ? 'is-invalid' : '' }}" min="0" max="100" placeholder="Optionnel">
                    @error('score_risque')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <p class="section-divider">Coordonnées géographiques</p>

                <div class="form-group">
                    <label for="latitude">Latitude <span style="color:#ea4335">*</span></label>
                    <input type="number" step="0.0000001" id="latitude" name="latitude" value="{{ old('latitude') }}" class="{{ $errors->has('latitude') ? 'is-invalid' : '' }}" placeholder="Ex: 36.7372">
                    @error('latitude')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="longitude">Longitude <span style="color:#ea4335">*</span></label>
                    <input type="number" step="0.0000001" id="longitude" name="longitude" value="{{ old('longitude') }}" class="{{ $errors->has('longitude') ? 'is-invalid' : '' }}" placeholder="Ex: 3.0869">
                    @error('longitude')<span class="error-msg">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.infrastructure.infrastructures.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

</x-admin-layout>
