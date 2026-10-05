{{-- Exemple d'utilisation du layout front --}}

@extends('components.project.layouts.front')

@section('title', 'Exemple Front Office')

@php
    // Définir la section hero (optionnel)
    $hero = [
        'title' => 'Découvrez nos Projets',
        'description' => 'Consultez les projets de rénovation en cours et contribuez à l\'amélioration du réseau d\'eau potable.'
    ];
@endphp

@section('content')

{{-- Section filtres --}}
<div class="aq-card" style="margin-bottom: 32px;">
    <div class="aq-card-body">
        <form method="GET" style="display: flex; gap: 16px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--navy);">Zone</label>
                <select class="aq-form-control" name="zone">
                    <option value="">Toutes les zones</option>
                    <option value="1">Tunis</option>
                    <option value="2">Sfax</option>
                    <option value="3">Sousse</option>
                </select>
            </div>
            
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--navy);">Type</label>
                <select class="aq-form-control" name="type">
                    <option value="">Tous les types</option>
                    <option value="renovation">Rénovation</option>
                    <option value="extension">Extension</option>
                    <option value="modernisation">Modernisation</option>
                </select>
            </div>
            
            <div style="display: flex; align-items: flex-end;">
                <button type="submit" class="aq-btn aq-btn-primary">Filtrer</button>
            </div>
        </form>
    </div>
</div>

{{-- Grille de projets --}}
<div class="aq-grid aq-grid-3">
    {{-- Carte projet 1 --}}
    <div class="aq-card">
        <img src="https://via.placeholder.com/400x200/1565c0/ffffff?text=Projet+1" alt="Projet 1" class="aq-card-image">
        <div class="aq-card-body">
            <div style="display: flex; gap: 8px; margin-bottom: 12px;">
                <span class="aq-badge aq-badge-success">En cours</span>
                <span class="aq-badge aq-badge-secondary">Rénovation</span>
            </div>
            <h3 class="aq-card-title">Rénovation Réseau Tunis Nord</h3>
            <p class="aq-card-text">
                Modernisation complète du réseau d'eau potable dans le quartier nord de Tunis avec installation de nouvelles canalisations.
            </p>
            <div style="margin-bottom: 16px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 4px; font-size: 0.9rem;">
                    <span style="color: var(--muted);">Budget</span>
                    <span style="font-weight: 600; color: var(--navy);">250 000 €</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.9rem;">
                    <span style="color: var(--muted);">Financement</span>
                    <span style="font-weight: 600; color: var(--success);">180 000 €</span>
                </div>
            </div>
            <a href="#" class="aq-btn aq-btn-primary aq-btn-block">Voir les détails</a>
        </div>
        <div class="aq-card-footer">
            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
                <span style="color: var(--muted);">Zone: Tunis</span>
                <span style="color: var(--muted);">Avancement: <strong style="color: var(--success);">65%</strong></span>
            </div>
        </div>
    </div>
    
    {{-- Carte projet 2 --}}
    <div class="aq-card">
        <img src="https://via.placeholder.com/400x200/00b8d9/ffffff?text=Projet+2" alt="Projet 2" class="aq-card-image">
        <div class="aq-card-body">
            <div style="display: flex; gap: 8px; margin-bottom: 12px;">
                <span class="aq-badge aq-badge-warning">Planifié</span>
                <span class="aq-badge aq-badge-secondary">Extension</span>
            </div>
            <h3 class="aq-card-title">Extension Réseau Sfax</h3>
            <p class="aq-card-text">
                Extension du réseau d'eau potable pour desservir les nouveaux quartiers en développement à l'est de Sfax.
            </p>
            <div style="margin-bottom: 16px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 4px; font-size: 0.9rem;">
                    <span style="color: var(--muted);">Budget</span>
                    <span style="font-weight: 600; color: var(--navy);">180 000 €</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.9rem;">
                    <span style="color: var(--muted);">Financement</span>
                    <span style="font-weight: 600; color: var(--warning);">95 000 €</span>
                </div>
            </div>
            <a href="#" class="aq-btn aq-btn-primary aq-btn-block">Voir les détails</a>
        </div>
        <div class="aq-card-footer">
            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
                <span style="color: var(--muted);">Zone: Sfax</span>
                <span style="color: var(--muted);">Avancement: <strong style="color: var(--warning);">20%</strong></span>
            </div>
        </div>
    </div>
    
    {{-- Carte projet 3 --}}
    <div class="aq-card">
        <img src="https://via.placeholder.com/400x200/0b2545/ffffff?text=Projet+3" alt="Projet 3" class="aq-card-image">
        <div class="aq-card-body">
            <div style="display: flex; gap: 8px; margin-bottom: 12px;">
                <span class="aq-badge aq-badge-info">Terminé</span>
                <span class="aq-badge aq-badge-secondary">Modernisation</span>
            </div>
            <h3 class="aq-card-title">Modernisation Sousse Centre</h3>
            <p class="aq-card-text">
                Modernisation des équipements de distribution et installation de compteurs intelligents dans le centre de Sousse.
            </p>
            <div style="margin-bottom: 16px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 4px; font-size: 0.9rem;">
                    <span style="color: var(--muted);">Budget</span>
                    <span style="font-weight: 600; color: var(--navy);">120 000 €</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.9rem;">
                    <span style="color: var(--muted);">Financement</span>
                    <span style="font-weight: 600; color: var(--success);">120 000 €</span>
                </div>
            </div>
            <a href="#" class="aq-btn aq-btn-primary aq-btn-block">Voir les détails</a>
        </div>
        <div class="aq-card-footer">
            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
                <span style="color: var(--muted);">Zone: Sousse</span>
                <span style="color: var(--muted);">Avancement: <strong style="color: var(--success);">100%</strong></span>
            </div>
        </div>
    </div>
</div>

{{-- Section CTA --}}
<div class="aq-card" style="margin-top: 48px; text-align: center;">
    <div class="aq-card-body" style="padding: 48px 24px;">
        <h2 style="color: var(--navy); font-size: 1.8rem; margin: 0 0 16px 0;">Soutenez nos Projets</h2>
        <p style="color: var(--muted); font-size: 1.1rem; max-width: 600px; margin: 0 auto 32px;">
            Votre contribution aide à améliorer l'accès à l'eau potable pour tous. Chaque don compte !
        </p>
        <a href="#" class="aq-btn aq-btn-success aq-btn-lg">
            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
            Faire un Don
        </a>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Styles personnalisés pour cette page */
    .aq-card-image {
        transition: transform 0.3s;
    }
    
    .aq-card:hover .aq-card-image {
        transform: scale(1.05);
    }
</style>
@endpush

@push('scripts')
<script>
    // Scripts personnalisés pour cette page
    console.log('Page front example chargée');
</script>
@endpush
