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
            <a href="{{ route('admin.infrastructure.maintenances.index') }}">Maintenances</a> /
            <a href="{{ route('admin.infrastructure.maintenances.show', $maintenance) }}">#{{ $maintenance->id }}</a> /
            Modifier
        </div>
        <h1>Modifier la maintenance #{{ $maintenance->id }}</h1>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('admin.infrastructure.maintenances.update', $maintenance) }}">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <p class="section-divider">Informations de l'intervention</p>

                <div class="form-group">
                    <label for="infrastructure_id">Infrastructure <span style="color:#ea4335">*</span></label>
                    <select id="infrastructure_id" name="infrastructure_id" class="{{ $errors->has('infrastructure_id') ? 'is-invalid' : '' }}">
                        <option value="">-- Sélectionner une infrastructure --</option>
                        @foreach($infrastructures as $infra)
                            <option value="{{ $infra->id }}" {{ old('infrastructure_id', $maintenance->infrastructure_id) == $infra->id ? 'selected' : '' }}>
                                {{ $infra->nom }} ({{ $infra->zone?->nom ?? 'Sans zone' }})
                            </option>
                        @endforeach
                    </select>
                    @error('infrastructure_id')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="technicien_id">Technicien <span style="color:#ea4335">*</span></label>
                    <select id="technicien_id" name="technicien_id" class="{{ $errors->has('technicien_id') ? 'is-invalid' : '' }}">
                        <option value="">-- Sélectionner un technicien --</option>
                        @foreach($techniciens as $tech)
                            <option value="{{ $tech->id }}" {{ old('technicien_id', $maintenance->technicien_id) == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                        @endforeach
                    </select>
                    @error('technicien_id')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="type">Type <span style="color:#ea4335">*</span></label>
                    <select id="type" name="type" class="{{ $errors->has('type') ? 'is-invalid' : '' }}">
                        <option value="">-- Sélectionner un type --</option>
                        @foreach(['preventive' => 'Préventive', 'corrective' => 'Corrective', 'urgence' => 'Urgence'] as $val => $label)
                            <option value="{{ $val }}" {{ old('type', $maintenance->type) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('type')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="statut">Statut <span style="color:#ea4335">*</span></label>
                    <select id="statut" name="statut" class="{{ $errors->has('statut') ? 'is-invalid' : '' }}">
                        <option value="">-- Sélectionner un statut --</option>
                        @foreach(['planifiee' => 'Planifiée', 'en_cours' => 'En cours', 'terminee' => 'Terminée', 'annulee' => 'Annulée'] as $val => $label)
                            <option value="{{ $val }}" {{ old('statut', $maintenance->statut) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('statut')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="date_intervention">Date d'intervention <span style="color:#ea4335">*</span></label>
                    <input type="date" id="date_intervention" name="date_intervention" value="{{ old('date_intervention', $maintenance->date_intervention?->format('Y-m-d')) }}" class="{{ $errors->has('date_intervention') ? 'is-invalid' : '' }}">
                    @error('date_intervention')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="cout">Coût (DA) <span style="color:#ea4335">*</span></label>
                    <input type="number" step="0.01" id="cout" name="cout" value="{{ old('cout', $maintenance->cout) }}" class="{{ $errors->has('cout') ? 'is-invalid' : '' }}" min="0">
                    @error('cout')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group form-full">
                    <label for="description">Description <span style="color:#ea4335">*</span></label>
                    <textarea id="description" name="description" rows="4" class="{{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description', $maintenance->description) }}</textarea>
                    @error('description')<span class="error-msg">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('admin.infrastructure.maintenances.show', $maintenance) }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

</x-admin-layout>
