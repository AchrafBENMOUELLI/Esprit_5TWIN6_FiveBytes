<style>{!! file_get_contents(resource_path('views/base.css')) !!}</style>

<x-shared.navbar />

<main class="aq-main" style="padding: 40px; max-width: 1400px; margin: 0 auto;">
    <div style="margin-bottom: 30px;">
        <h1 style="color: var(--navy); margin-bottom: 10px;">Nos Projets de Rénovation</h1>
        <p style="color: var(--gray); font-size: 1.1rem;">
            Découvrez les projets de rénovation et d'amélioration du réseau d'eau potable dans votre zone
        </p>
    </div>

    {{-- Filtres --}}
    <div style="background: white; padding: 20px; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <form method="GET" action="{{ route('project.index') }}" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: end;">
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: var(--navy);">Zone</label>
                <select name="zone_id" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                    <option value="">Toutes les zones</option>
                    @foreach($zones as $zone)
                        <option value="{{ $zone->id }}" {{ request('zone_id') == $zone->id ? 'selected' : '' }}>
                            {{ $zone->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: var(--navy);">Type</label>
                <select name="type" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                    <option value="">Tous les types</option>
                    <option value="rénovation" {{ request('type') == 'rénovation' ? 'selected' : '' }}>Rénovation</option>
                    <option value="décontamination" {{ request('type') == 'décontamination' ? 'selected' : '' }}>Décontamination</option>
                    <option value="extension" {{ request('type') == 'extension' ? 'selected' : '' }}>Extension</option>
                    <option value="modernisation" {{ request('type') == 'modernisation' ? 'selected' : '' }}>Modernisation</option>
                </select>
            </div>

            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: var(--navy);">Statut</label>
                <select name="statut" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                    <option value="">Tous les statuts</option>
                    <option value="planifié" {{ request('statut') == 'planifié' ? 'selected' : '' }}>Planifié</option>
                    <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                    <option value="terminé" {{ request('statut') == 'terminé' ? 'selected' : '' }}>Terminé</option>
                </select>
            </div>

            <div>
                <button type="submit" style="padding: 10px 24px; background: var(--aqua); color: var(--navy); border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">
                    Filtrer
                </button>
                @if(request()->hasAny(['zone_id', 'type', 'statut']))
                    <a href="{{ route('project.index') }}" style="padding: 10px 24px; background: #e5e7eb; color: #374151; border-radius: 6px; font-weight: 600; text-decoration: none; display: inline-block; margin-left: 10px;">
                        Réinitialiser
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Grille de projets --}}
    @if($projects->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 24px; margin-bottom: 30px;">
            @foreach($projects as $project)
                <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: transform 0.2s, box-shadow 0.2s;" 
                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.15)';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)';">
                    
                    {{-- Header avec statut --}}
                    <div style="background: linear-gradient(135deg, var(--ocean), var(--navy)); padding: 20px; color: white;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                            <span style="padding: 4px 12px; background: rgba(255,255,255,0.2); border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                {{ ucfirst($project->type) }}
                            </span>
                            <span style="padding: 4px 12px; background: 
                                @if($project->statut === 'en_cours') #10b981
                                @elseif($project->statut === 'terminé') #6b7280
                                @elseif($project->statut === 'planifié') #3b82f6
                                @else #f59e0b
                                @endif; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                {{ ucfirst(str_replace('_', ' ', $project->statut)) }}
                            </span>
                        </div>
                        <h3 style="margin: 0; font-size: 1.25rem;">{{ $project->titre }}</h3>
                    </div>

                    {{-- Corps --}}
                    <div style="padding: 20px;">
                        <p style="color: var(--gray); margin-bottom: 15px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $project->description }}
                        </p>

                        <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 15px;">
                            <div style="display: flex; align-items: center; gap: 8px; color: var(--navy);">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                </svg>
                                <span style="font-size: 0.9rem;">{{ $project->zone->nom }}</span>
                            </div>

                            <div style="display: flex; align-items: center; gap: 8px; color: var(--navy);">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                </svg>
                                <span style="font-size: 0.9rem;">{{ $project->date_debut->format('d/m/Y') }} - {{ $project->date_fin_prevue->format('d/m/Y') }}</span>
                            </div>

                            <div style="display: flex; align-items: center; gap: 8px; color: var(--navy);">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
                                </svg>
                                <span style="font-size: 0.9rem; font-weight: 600;">{{ number_format($project->budget_prevu, 0, ',', ' ') }} €</span>
                            </div>
                        </div>

                        {{-- Barre de progression --}}
                        <div style="margin-bottom: 15px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                <span style="font-size: 0.85rem; color: var(--gray);">Avancement</span>
                                <span style="font-size: 0.85rem; font-weight: 600; color: var(--navy);">{{ $project->avancement_pourcentage }}%</span>
                            </div>
                            <div style="width: 100%; height: 8px; background: #e5e7eb; border-radius: 10px; overflow: hidden;">
                                <div style="height: 100%; background: linear-gradient(90deg, var(--aqua), var(--ocean)); width: {{ $project->avancement_pourcentage }}%; transition: width 0.3s;"></div>
                            </div>
                        </div>

                        <a href="{{ route('project.show', $project) }}" 
                           style="display: block; text-align: center; padding: 12px; background: var(--aqua); color: var(--navy); text-decoration: none; border-radius: 8px; font-weight: 600; transition: background 0.2s;"
                           onmouseover="this.style.background='var(--ocean)'; this.style.color='white';"
                           onmouseout="this.style.background='var(--aqua)'; this.style.color='var(--navy)';">
                            Voir les détails
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div style="display: flex; justify-content: center;">
            {{ $projects->links() }}
        </div>
    @else
        <div style="background: white; padding: 60px 20px; border-radius: 12px; text-align: center;">
            <svg width="64" height="64" fill="var(--gray)" viewBox="0 0 16 16" style="margin-bottom: 20px; opacity: 0.5;">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg>
            <h3 style="color: var(--navy); margin-bottom: 10px;">Aucun projet trouvé</h3>
            <p style="color: var(--gray);">Essayez de modifier vos filtres pour voir plus de projets.</p>
        </div>
    @endif
</main>

<x-shared.footer />
