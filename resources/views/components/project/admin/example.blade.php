{{-- Exemple d'utilisation du layout admin --}}

@extends('components.project.layouts.admin')

@section('title', 'Exemple Admin')

@php
    // Définir le fil d'Ariane (breadcrumb)
    $breadcrumbs = [
        ['label' => 'Projets', 'url' => route('admin.project.index')],
        ['label' => 'Exemple']
    ];
    
    // Définir l'en-tête de la page
    $header = 'Exemple de Page Admin';
    $description = 'Cette page démontre l\'utilisation du layout admin avec tous les composants disponibles.';
    
    // Actions dans l'en-tête (boutons à droite)
    $headerActions = '<a href="'.route('admin.project.create').'" class="aq-btn aq-btn-primary">
        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Nouveau Projet
    </a>';
@endphp

@section('content')

{{-- Carte avec tableau --}}
<div class="aq-card">
    <div class="aq-card-header">
        <h3 class="aq-card-title">Liste des Projets</h3>
        <div style="display: flex; gap: 12px;">
            <button class="aq-btn aq-btn-sm aq-btn-secondary">Filtrer</button>
            <button class="aq-btn aq-btn-sm aq-btn-secondary">Exporter</button>
        </div>
    </div>
    <div class="aq-card-body" style="padding: 0;">
        <table class="aq-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Statut</th>
                    <th>Budget</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#001</td>
                    <td>Rénovation Réseau Tunis</td>
                    <td><span class="aq-badge aq-badge-success">En cours</span></td>
                    <td>250 000 €</td>
                    <td>
                        <button class="aq-btn aq-btn-sm aq-btn-primary">Voir</button>
                        <button class="aq-btn aq-btn-sm aq-btn-secondary">Modifier</button>
                    </td>
                </tr>
                <tr>
                    <td>#002</td>
                    <td>Extension Sfax</td>
                    <td><span class="aq-badge aq-badge-warning">Planifié</span></td>
                    <td>180 000 €</td>
                    <td>
                        <button class="aq-btn aq-btn-sm aq-btn-primary">Voir</button>
                        <button class="aq-btn aq-btn-sm aq-btn-secondary">Modifier</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="aq-card-footer">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span style="color: var(--muted); font-size: 0.9rem;">Affichage 1-2 sur 2</span>
            <div style="display: flex; gap: 8px;">
                <button class="aq-btn aq-btn-sm aq-btn-secondary" disabled>Précédent</button>
                <button class="aq-btn aq-btn-sm aq-btn-secondary" disabled>Suivant</button>
            </div>
        </div>
    </div>
</div>

{{-- Grille de cartes statistiques --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-top: 24px;">
    <div class="aq-card">
        <div class="aq-card-body">
            <h4 style="margin: 0 0 8px 0; color: var(--muted); font-size: 0.9rem; font-weight: 500;">Total Projets</h4>
            <p style="margin: 0; font-size: 2rem; font-weight: 700; color: var(--navy);">42</p>
        </div>
    </div>
    
    <div class="aq-card">
        <div class="aq-card-body">
            <h4 style="margin: 0 0 8px 0; color: var(--muted); font-size: 0.9rem; font-weight: 500;">En Cours</h4>
            <p style="margin: 0; font-size: 2rem; font-weight: 700; color: var(--success);">15</p>
        </div>
    </div>
    
    <div class="aq-card">
        <div class="aq-card-body">
            <h4 style="margin: 0 0 8px 0; color: var(--muted); font-size: 0.9rem; font-weight: 500;">Budget Total</h4>
            <p style="margin: 0; font-size: 2rem; font-weight: 700; color: var(--ocean);">2.5M €</p>
        </div>
    </div>
</div>

{{-- Formulaire exemple --}}
<div class="aq-card" style="margin-top: 24px;">
    <div class="aq-card-header">
        <h3 class="aq-card-title">Exemple de Formulaire</h3>
    </div>
    <div class="aq-card-body">
        <form>
            <div class="aq-form-group">
                <label class="aq-form-label aq-form-label-required">Titre du projet</label>
                <input type="text" class="aq-form-control" name="titre" placeholder="Ex: Rénovation réseau...">
                <small class="aq-form-text">Le titre doit être clair et descriptif.</small>
            </div>
            
            <div class="aq-form-group">
                <label class="aq-form-label">Description</label>
                <textarea class="aq-form-control" name="description" rows="4" placeholder="Décrivez le projet..."></textarea>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="aq-form-group">
                    <label class="aq-form-label aq-form-label-required">Type</label>
                    <select class="aq-form-control" name="type">
                        <option value="">Sélectionnez...</option>
                        <option value="renovation">Rénovation</option>
                        <option value="extension">Extension</option>
                        <option value="modernisation">Modernisation</option>
                    </select>
                </div>
                
                <div class="aq-form-group">
                    <label class="aq-form-label aq-form-label-required">Budget (€)</label>
                    <input type="number" class="aq-form-control" name="budget" placeholder="0.00">
                </div>
            </div>
            
            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px;">
                <button type="button" class="aq-btn aq-btn-secondary">Annuler</button>
                <button type="submit" class="aq-btn aq-btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Styles personnalisés pour cette page */
    .aq-card:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        transition: box-shadow 0.2s;
    }
</style>
@endpush

@push('scripts')
<script>
    // Scripts personnalisés pour cette page
    console.log('Page admin example chargée');
    
    // Exemple: confirmation de suppression
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush
