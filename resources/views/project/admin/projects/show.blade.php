@php
use Carbon\Carbon;
@endphp

<x-project.layouts.admin 
    title="{{ $project->titre }}"
    :breadcrumbs="[
        ['label' => 'Tableau de bord', 'url' => route('admin.dashboard')],
        ['label' => 'Projets', 'url' => route('admin.projects.index')],
        ['label' => $project->titre, 'url' => null]
    ]">

    {{-- En-tête du projet --}}
    <div class="aq-card">
        <div class="aq-card-header">
            <div>
                <h2 class="aq-card-title">{{ $project->titre }}</h2>
                <p class="aq-card-subtitle">
                    @php
                        $badgeClass = match($project->statut) {
                            'planifié' => 'aq-badge-secondary',
                            'en_cours' => 'aq-badge-primary',
                            'terminé' => 'aq-badge-success',
                            'suspendu' => 'aq-badge-warning',
                            'annulé' => 'aq-badge-danger',
                            default => 'aq-badge-secondary'
                        };
                    @endphp
                    <span class="aq-badge {{ $badgeClass }}">
                        {{ ucfirst(str_replace('_', ' ', $project->statut)) }}
                    </span>
                    <span class="aq-badge aq-badge-info">{{ ucfirst($project->type) }}</span>
                </p>
            </div>
            <div class="aq-actions">
                <a href="{{ route('admin.projects.edit', $project) }}" class="aq-btn aq-btn-primary">
                    <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier
                </a>
                <a href="{{ route('admin.projects.index') }}" class="aq-btn aq-btn-outline">
                    Retour à la liste
                </a>
            </div>
        </div>

        {{-- Informations générales --}}
        <div class="aq-grid-3">
            <div>
                <h3 style="font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Zone</h3>
                <p>{{ $project->zone->nom ?? 'Non définie' }}</p>
            </div>
            <div>
                <h3 style="font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Infrastructure</h3>
                <p>{{ $project->infrastructure->nom ?? 'Non définie' }}</p>
                @if($project->infrastructure)
                    <small class="aq-text-muted">{{ ucfirst($project->infrastructure->type) }}</small>
                @endif
            </div>
            <div>
                <h3 style="font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Responsable</h3>
                <p>{{ $project->responsable->name ?? 'Non assigné' }}</p>
                @if($project->responsable)
                    <small class="aq-text-muted">{{ $project->responsable->email }}</small>
                @endif
            </div>
        </div>

        <div style="margin-top: 1.5rem;">
            <h3 style="font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Description</h3>
            <p style="color: var(--text-secondary); line-height: 1.6;">{{ $project->description }}</p>
        </div>

        {{-- Dates --}}
        <div class="aq-grid-2" style="margin-top: 1.5rem;">
            <div>
                <h3 style="font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Date de début</h3>
                <p>{{ Carbon::parse($project->date_debut)->format('d/m/Y') }}</p>
            </div>
            <div>
                <h3 style="font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Date de fin prévue</h3>
                <p>{{ Carbon::parse($project->date_fin_prevue)->format('d/m/Y') }}</p>
                @php
                    $now = Carbon::now();
                    $finPrevue = Carbon::parse($project->date_fin_prevue);
                    $joursRestants = $now->diffInDays($finPrevue, false);
                @endphp
                @if($joursRestants < 0)
                    <small class="aq-badge aq-badge-danger">Retard de {{ abs($joursRestants) }} jours</small>
                @elseif($joursRestants <= 30)
                    <small class="aq-badge aq-badge-warning">{{ $joursRestants }} jours restants</small>
                @else
                    <small class="aq-badge aq-badge-success">{{ $joursRestants }} jours restants</small>
                @endif
            </div>
        </div>

        {{-- Avancement --}}
        <div style="margin-top: 1.5rem;">
            <h3 style="font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">
                Avancement du projet: {{ $project->avancement_pourcentage }}%
            </h3>
            <div class="aq-progress" style="height: 2rem;">
                <div class="aq-progress-bar" style="width: {{ $project->avancement_pourcentage }}%">
                    {{ $project->avancement_pourcentage }}%
                </div>
            </div>
        </div>
    </div>

    {{-- Budget et financement --}}
    <div class="aq-grid-3" style="margin-top: 1.5rem;">
        <div class="aq-stat-card">
            <div class="aq-stat-label">Budget prévu</div>
            <div class="aq-stat-value">{{ number_format($project->budget_prevu, 0, ',', ' ') }} €</div>
        </div>
        <div class="aq-stat-card">
            <div class="aq-stat-label">Financement obtenu</div>
            <div class="aq-stat-value">{{ number_format($project->fundingTotal(), 0, ',', ' ') }} €</div>
            @php
                $tauxFinancement = $project->budget_prevu > 0 ? ($project->fundingTotal() / $project->budget_prevu) * 100 : 0;
            @endphp
            <div class="aq-progress" style="margin-top: 0.5rem;">
                <div class="aq-progress-bar" style="width: {{ min($tauxFinancement, 100) }}%"></div>
            </div>
        </div>
        <div class="aq-stat-card">
            <div class="aq-stat-label">Budget restant</div>
            <div class="aq-stat-value" style="color: {{ $project->budgetRemaining() < 0 ? 'var(--danger)' : 'var(--success)' }}">
                {{ number_format($project->budgetRemaining(), 0, ',', ' ') }} €
            </div>
            @if($project->budgetRemaining() < 0)
                <small class="aq-badge aq-badge-danger">Dépassement</small>
            @endif
        </div>
    </div>

    {{-- Phases du projet --}}
    <div class="aq-card" style="margin-top: 1.5rem;">
        <div class="aq-card-header">
            <div>
                <h2 class="aq-card-title">Phases du Projet</h2>
                <p class="aq-card-subtitle">{{ $project->projectPhases->count() }} phase(s) définie(s)</p>
            </div>
            <a href="{{ route('admin.project-phases.create', ['project_id' => $project->id]) }}" class="aq-btn aq-btn-primary">
                <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Ajouter une phase
            </a>
        </div>

        @if($project->projectPhases->count() > 0)
            <div class="aq-table-responsive">
                <table class="aq-table">
                    <thead>
                        <tr>
                            <th>Phase</th>
                            <th>Contractant</th>
                            <th>Période</th>
                            <th>Coût</th>
                            <th>Avancement</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($project->projectPhases as $phase)
                            <tr>
                                <td>
                                    <strong>{{ $phase->nom }}</strong>
                                </td>
                                <td>{{ $phase->contractor->nom ?? 'Non assigné' }}</td>
                                <td>
                                    <small class="aq-text-muted">
                                        {{ Carbon::parse($phase->date_debut)->format('d/m/Y') }}<br>
                                        → {{ Carbon::parse($phase->date_fin)->format('d/m/Y') }}
                                    </small>
                                </td>
                                <td>
                                    <strong>{{ number_format($phase->cout, 0, ',', ' ') }} €</strong>
                                </td>
                                <td>
                                    <div class="aq-progress">
                                        <div class="aq-progress-bar" style="width: {{ $phase->avancement }}%"></div>
                                    </div>
                                    <small class="aq-text-muted">{{ $phase->avancement }}%</small>
                                </td>
                                <td>
                                    <div class="aq-actions">
                                        <a href="{{ route('admin.project-phases.edit', $phase) }}" class="aq-btn-icon" title="Modifier">
                                            <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.project-phases.destroy', $phase) }}" 
                                              method="POST" 
                                              style="display: inline;"
                                              onsubmit="return confirm('Supprimer cette phase ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="aq-btn-icon aq-btn-danger" title="Supprimer">
                                                <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="font-weight: 600; background: var(--bg);">
                            <td colspan="3">Total</td>
                            <td>{{ number_format($project->projectPhases->sum('cout'), 0, ',', ' ') }} €</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="aq-table-empty">
                <p>Aucune phase définie pour ce projet.</p>
                <a href="{{ route('admin.project-phases.create', ['project_id' => $project->id]) }}" class="aq-btn aq-btn-primary" style="margin-top: 1rem;">
                    Créer la première phase
                </a>
            </div>
        @endif
    </div>

    {{-- Financements --}}
    <div class="aq-card" style="margin-top: 1.5rem;">
        <div class="aq-card-header">
            <div>
                <h2 class="aq-card-title">Financements</h2>
                <p class="aq-card-subtitle">{{ $project->fundings->count() }} source(s) de financement</p>
            </div>
            <a href="{{ route('admin.fundings.create', ['project_id' => $project->id]) }}" class="aq-btn aq-btn-primary">
                <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Ajouter un financement
            </a>
        </div>

        @if($project->fundings->count() > 0)
            <div class="aq-table-responsive">
                <table class="aq-table">
                    <thead>
                        <tr>
                            <th>Source</th>
                            <th>Montant</th>
                            <th>Date d'obtention</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($project->fundings as $funding)
                            <tr>
                                <td>
                                    <strong>{{ ucfirst($funding->source) }}</strong>
                                    @if($funding->donateur)
                                        <br><small class="aq-text-muted">Don de {{ $funding->donateur->name }}</small>
                                    @endif
                                    @if($funding->description)
                                        <br><small class="aq-text-muted">{{ Str::limit($funding->description, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ number_format($funding->montant, 0, ',', ' ') }} €</strong>
                                </td>
                                <td>{{ Carbon::parse($funding->date_obtention)->format('d/m/Y') }}</td>
                                <td>
                                    @php
                                        $fundingBadge = match($funding->statut) {
                                            'confirmé' => 'aq-badge-success',
                                            'en_attente' => 'aq-badge-warning',
                                            'refusé' => 'aq-badge-danger',
                                            default => 'aq-badge-secondary'
                                        };
                                    @endphp
                                    <span class="aq-badge {{ $fundingBadge }}">
                                        {{ ucfirst(str_replace('_', ' ', $funding->statut)) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="aq-actions">
                                        @if($funding->statut === 'en_attente')
                                            <form action="{{ route('admin.fundings.approve', $funding) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="aq-btn-icon aq-btn-success" title="Approuver">
                                                    <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.fundings.reject', $funding) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="aq-btn-icon aq-btn-danger" title="Refuser">
                                                    <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('admin.fundings.edit', $funding) }}" class="aq-btn-icon" title="Modifier">
                                            <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.fundings.destroy', $funding) }}" 
                                              method="POST" 
                                              style="display: inline;"
                                              onsubmit="return confirm('Supprimer ce financement ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="aq-btn-icon aq-btn-danger" title="Supprimer">
                                                <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="font-weight: 600; background: var(--bg);">
                            <td>Total</td>
                            <td>{{ number_format($project->fundings->sum('montant'), 0, ',', ' ') }} €</td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="aq-table-empty">
                <p>Aucun financement enregistré pour ce projet.</p>
                <a href="{{ route('admin.fundings.create', ['project_id' => $project->id]) }}" class="aq-btn aq-btn-primary" style="margin-top: 1rem;">
                    Ajouter le premier financement
                </a>
            </div>
        @endif
    </div>

    {{-- Documents --}}
    <div class="aq-card" style="margin-top: 1.5rem;">
        <div class="aq-card-header">
            <div>
                <h2 class="aq-card-title">Documents</h2>
                <p class="aq-card-subtitle">{{ $project->projectDocuments->count() }} document(s)</p>
            </div>
            <a href="{{ route('admin.project-documents.create', ['project_id' => $project->id]) }}" class="aq-btn aq-btn-primary">
                <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Ajouter un document
            </a>
        </div>

        @if($project->projectDocuments->count() > 0)
            <div class="aq-grid-3">
                @foreach($project->projectDocuments as $document)
                    <div class="aq-document-card">
                        <div class="aq-document-icon">
                            <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="aq-document-info">
                            <h4>{{ $document->nom }}</h4>
                            <p class="aq-text-muted">{{ ucfirst($document->type_document) }}</p>
                            @if($document->description)
                                <p style="font-size: 0.875rem; margin-top: 0.5rem;">{{ Str::limit($document->description, 60) }}</p>
                            @endif
                        </div>
                        <div class="aq-document-actions">
                            <a href="{{ Storage::url($document->chemin_fichier) }}" class="aq-btn-icon" title="Télécharger" download>
                                <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.project-documents.destroy', $document) }}" 
                                  method="POST" 
                                  style="display: inline;"
                                  onsubmit="return confirm('Supprimer ce document ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="aq-btn-icon aq-btn-danger" title="Supprimer">
                                    <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="aq-table-empty">
                <p>Aucun document attaché à ce projet.</p>
                <a href="{{ route('admin.project-documents.create', ['project_id' => $project->id]) }}" class="aq-btn aq-btn-primary" style="margin-top: 1rem;">
                    Ajouter le premier document
                </a>
            </div>
        @endif
    </div>

</x-project.layouts.admin>
