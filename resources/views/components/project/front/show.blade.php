<style>{!! file_get_contents(resource_path('views/base.css')) !!}</style>

<x-shared.navbar />

<main class="aq-main" style="padding: 40px; max-width: 1400px; margin: 0 auto;">
    {{-- Header --}}
    <div style="margin-bottom: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 20px; margin-bottom: 20px;">
            <div style="flex: 1;">
                <h1 style="color: var(--navy); margin: 0 0 15px 0; font-size: 2.5rem;">{{ $project->titre }}</h1>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <span style="display: inline-flex; align-items: center; padding: 6px 16px; border-radius: 20px; font-size: 0.9rem; font-weight: 600;
                        @if($project->statut === 'planifie') background: #fef3c7; color: #92400e;
                        @elseif($project->statut === 'en_cours') background: #dbeafe; color: #1e40af;
                        @elseif($project->statut === 'termine') background: #d1fae5; color: #065f46;
                        @elseif($project->statut === 'suspendu') background: #fee2e2; color: #991b1b;
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $project->statut)) }}
                    </span>
                    <span style="display: inline-flex; align-items: center; padding: 6px 16px; border-radius: 20px; font-size: 0.9rem; font-weight: 600; background: #e9d5ff; color: #6b21a8;">
                        {{ ucfirst($project->type) }}
                    </span>
                </div>
            </div>
            <div style="text-align: right;">
                <div style="font-size: 0.9rem; color: var(--gray); margin-bottom: 5px;">Budget Total</div>
                <div style="font-size: 2rem; font-weight: bold; color: var(--navy);">{{ number_format($project->budget_prevu, 2, ',', ' ') }} €</div>
            </div>
        </div>
        <a href="{{ route('project.index') }}" style="color: var(--ocean); text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
            ← Retour aux projets
        </a>
    </div>

    {{-- Project Info --}}
    <div style="background: white; padding: 30px; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; padding-bottom: 20px; border-bottom: 2px solid #e5e7eb;">
            <div>
                <div style="font-size: 0.85rem; color: var(--gray); margin-bottom: 5px;">Date de début</div>
                <div style="font-size: 1.1rem; font-weight: 600; color: var(--navy);">{{ \Carbon\Carbon::parse($project->date_debut)->format('d/m/Y') }}</div>
            </div>
            <div>
                <div style="font-size: 0.85rem; color: var(--gray); margin-bottom: 5px;">Date de fin prévue</div>
                <div style="font-size: 1.1rem; font-weight: 600; color: var(--navy);">
                    @if($project->date_fin_prevue)
                        {{ \Carbon\Carbon::parse($project->date_fin_prevue)->format('d/m/Y') }}
                    @else
                        <span style="color: #9ca3af;">Non définie</span>
                    @endif
                </div>
            </div>
            <div>
                <div style="font-size: 0.85rem; color: var(--gray); margin-bottom: 5px;">Responsable</div>
                <div style="font-size: 1.1rem; font-weight: 600; color: var(--navy);">{{ $project->responsable->name }}</div>
            </div>
        </div>

        <div style="padding-top: 20px;">
            <h3 style="font-size: 1.2rem; font-weight: 600; color: var(--navy); margin-bottom: 10px;">Description</h3>
            <p style="color: var(--gray); line-height: 1.6;">{{ $project->description }}</p>
        </div>

        @if($project->zone || $project->infrastructure)
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 20px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            @if($project->zone)
            <div>
                <div style="font-size: 0.85rem; color: var(--gray); margin-bottom: 5px;">Zone concernée</div>
                <div style="font-size: 1rem; font-weight: 500; color: var(--navy);">{{ $project->zone->nom }}</div>
            </div>
            @endif
            @if($project->infrastructure)
            <div>
                <div style="font-size: 0.85rem; color: var(--gray); margin-bottom: 5px;">Infrastructure associée</div>
                <div style="font-size: 1rem; font-weight: 500; color: var(--navy);">{{ $project->infrastructure->nom }}</div>
            </div>
            @endif
        </div>
        @endif
    </div>

    {{-- Budget et Financement --}}
    <div style="background: white; padding: 30px; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h2 style="font-size: 1.8rem; font-weight: bold; color: var(--navy); margin-bottom: 25px;">Budget et Financement</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <div style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 12px; padding: 20px;">
                <div style="font-size: 0.9rem; color: #1e40af; margin-bottom: 5px; font-weight: 500;">Budget Prévu</div>
                <div style="font-size: 1.8rem; font-weight: bold; color: #1e3a8a;">{{ number_format($project->budget_prevu, 2, ',', ' ') }} €</div>
            </div>
            <div style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); border-radius: 12px; padding: 20px;">
                <div style="font-size: 0.9rem; color: #065f46; margin-bottom: 5px; font-weight: 500;">Financement Obtenu</div>
                <div style="font-size: 1.8rem; font-weight: bold; color: #064e3b;">{{ number_format($project->fundingTotal(), 2, ',', ' ') }} €</div>
            </div>
            <div style="background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%); border-radius: 12px; padding: 20px;">
                <div style="font-size: 0.9rem; color: #9a3412; margin-bottom: 5px; font-weight: 500;">Budget Restant</div>
                <div style="font-size: 1.8rem; font-weight: bold; color: #7c2d12;">{{ number_format($project->budgetRemaining(), 2, ',', ' ') }} €</div>
            </div>
        </div>

        @if($project->fundings->count() > 0)
        <h3 style="font-size: 1.2rem; font-weight: 600; color: var(--navy); margin-bottom: 15px;">Sources de Financement</h3>
        <div style="display: flex; flex-direction: column; gap: 15px;">
            @foreach($project->fundings as $funding)
            <div style="border: 1px solid #e5e7eb; border-radius: 10px; padding: 20px; transition: all 0.2s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='white'">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 15px;">
                    <div style="flex: 1;">
                        <div style="font-size: 1.3rem; font-weight: 600; color: var(--navy); margin-bottom: 8px;">{{ number_format($funding->montant, 2, ',', ' ') }} €</div>
                        <div style="font-size: 0.9rem; color: var(--gray); margin-bottom: 5px;">
                            Source: <span style="font-weight: 600; color: var(--navy);">{{ ucfirst($funding->source) }}</span>
                        </div>
                        @if($funding->description)
                        <div style="font-size: 0.9rem; color: var(--gray); margin-top: 8px;">{{ $funding->description }}</div>
                        @endif
                        @if($funding->donateur)
                        <div style="font-size: 0.9rem; color: var(--gray); margin-top: 5px;">
                            Donateur: <span style="font-weight: 600;">{{ $funding->donateur->name }}</span>
                        </div>
                        @endif
                    </div>
                    <div style="text-align: right;">
                        <span style="display: inline-flex; align-items: center; padding: 4px 12px; border-radius: 15px; font-size: 0.8rem; font-weight: 600;
                            @if($funding->statut === 'approuve') background: #d1fae5; color: #065f46;
                            @elseif($funding->statut === 'en_attente') background: #fef3c7; color: #92400e;
                            @elseif($funding->statut === 'rejete') background: #fee2e2; color: #991b1b;
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $funding->statut)) }}
                        </span>
                        <div style="font-size: 0.75rem; color: var(--gray); margin-top: 5px;">{{ \Carbon\Carbon::parse($funding->date_obtention)->format('d/m/Y') }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div style="text-align: center; padding: 50px 20px; color: var(--gray);">
            Aucun financement enregistré pour ce projet.
        </div>
        @endif
    </div>

    {{-- Phases du Projet --}}
    @if($project->projectPhases->count() > 0)
    <div style="background: white; padding: 30px; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h2 style="font-size: 1.8rem; font-weight: bold; color: var(--navy); margin-bottom: 25px;">Phases du Projet</h2>
        <div style="display: flex; flex-direction: column; gap: 20px;">
            @foreach($project->projectPhases->sortBy('date_debut') as $phase)
            <div style="border-left: 4px solid var(--ocean); background: #f9fafb; padding: 20px; border-radius: 0 10px 10px 0;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 15px;">
                    <div style="flex: 1;">
                        <h3 style="font-size: 1.2rem; font-weight: 600; color: var(--navy); margin-bottom: 15px;">{{ $phase->nom }}</h3>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                            <div>
                                <div style="font-size: 0.75rem; color: var(--gray); margin-bottom: 3px;">Période</div>
                                <div style="font-size: 0.9rem; font-weight: 600; color: var(--navy);">
                                    {{ \Carbon\Carbon::parse($phase->date_debut)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($phase->date_fin)->format('d/m/Y') }}
                                </div>
                            </div>
                            <div>
                                <div style="font-size: 0.75rem; color: var(--gray); margin-bottom: 3px;">Coût</div>
                                <div style="font-size: 0.9rem; font-weight: 600; color: var(--navy);">{{ number_format($phase->cout, 2, ',', ' ') }} €</div>
                            </div>
                            <div>
                                <div style="font-size: 0.75rem; color: var(--gray); margin-bottom: 3px;">Entrepreneur</div>
                                <div style="font-size: 0.9rem; font-weight: 600; color: var(--navy);">{{ $phase->contractor->nom }}</div>
                            </div>
                            <div>
                                <div style="font-size: 0.75rem; color: var(--gray); margin-bottom: 3px;">Avancement</div>
                                <div style="font-size: 0.9rem; font-weight: 600; color: var(--navy);">{{ $phase->avancement }}%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div style="margin-top: 25px; padding-top: 25px; border-top: 2px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
            <span style="font-size: 1rem; font-weight: 600; color: var(--gray);">Budget total des phases:</span>
            <span style="font-size: 1.3rem; font-weight: bold; color: var(--navy);">{{ number_format($project->budgetTotal(), 2, ',', ' ') }} €</span>
        </div>
    </div>
    @endif

    {{-- Documents du Projet --}}
    @if($project->projectDocuments->count() > 0)
    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h2 style="font-size: 1.8rem; font-weight: bold; color: var(--navy); margin-bottom: 25px;">Documents du Projet</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
            @foreach($project->projectDocuments as $document)
            <div style="border: 1px solid #e5e7eb; border-radius: 10px; padding: 20px; transition: all 0.2s;" onmouseover="this.style.background='#f9fafb'; this.style.borderColor='var(--ocean)'" onmouseout="this.style.background='white'; this.style.borderColor='#e5e7eb'">
                <div style="display: flex; gap: 15px;">
                    <div style="flex-shrink: 0;">
                        <svg style="width: 35px; height: 35px; color: var(--ocean);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <h3 style="font-size: 0.95rem; font-weight: 600; color: var(--navy); margin-bottom: 5px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $document->nom }}</h3>
                        <p style="font-size: 0.8rem; color: var(--gray); margin-bottom: 5px;">
                            Type: <span style="font-weight: 600;">{{ ucfirst($document->type_document) }}</span>
                        </p>
                        @if($document->description)
                        <p style="font-size: 0.8rem; color: var(--gray); margin-bottom: 10px;">{{ Str::limit($document->description, 60) }}</p>
                        @endif
                        <a href="{{ Storage::url($document->chemin_fichier) }}" 
                           target="_blank"
                           style="font-size: 0.85rem; color: var(--ocean); text-decoration: none; font-weight: 600; display: inline-block; margin-bottom: 5px;">
                            Télécharger →
                        </a>
                        <div style="font-size: 0.75rem; color: #9ca3af;">
                            Ajouté le {{ \Carbon\Carbon::parse($document->created_at)->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</main>
