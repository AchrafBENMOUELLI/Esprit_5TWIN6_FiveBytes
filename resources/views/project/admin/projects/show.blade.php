@extends('layouts.admin')

@section('title', 'Détails du Projet')

@section('content')
<x-project.layouts.admin
    title="Détails du Projet"
    :breadcrumbs="[
        ['label' => 'Tableau de bord', 'url' => route('dashboard')],
        ['label' => 'Projets', 'url' => route('admin.projects.index')],
        ['label' => 'Détails', 'url' => null]
    ]">

<style>
    .minimal-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(30, 64, 175, 0.08);
    }

    .minimal-stat-box {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(30, 64, 175, 0.08);
        margin-bottom: 16px;
    }

    .stat-label-sm {
        font-size: 12px;
        color: #94a3b8;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .stat-value-lg {
        font-size: 32px;
        font-weight: 700;
        line-height: 1;
    }

    .stat-value-lg.blue { color: #3b82f6; }
    .stat-value-lg.cyan { color: #06b6d4; }
    .stat-value-lg.green { color: #10b981; }
    .stat-value-lg.amber { color: #f59e0b; }

    .minimal-progress-sm {
        height: 8px;
        background: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
        margin-top: 8px;
    }

    .minimal-progress-bar-sm {
        height: 100%;
        background: linear-gradient(90deg, #3b82f6, #60a5fa);
        border-radius: 4px;
        transition: width 0.6s ease;
    }

    .info-row {
        padding: 16px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .info-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-label {
        font-size: 12px;
        color: #94a3b8;
        font-weight: 500;
        margin-bottom: 6px;
    }

    .info-value {
        font-size: 14px;
        color: #1e293b;
        font-weight: 500;
    }

    .minimal-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
    }

    .minimal-badge.type {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
        color: #6366f1;
    }

    .minimal-badge.status-planned {
        background: rgba(100, 116, 139, 0.1);
        color: #64748b;
    }

    .minimal-badge.status-in-progress {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(96, 165, 250, 0.15));
        color: #3b82f6;
    }

    .minimal-badge.status-completed {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(52, 211, 153, 0.15));
        color: #10b981;
    }

    .minimal-badge.status-suspended {
        background: rgba(245, 158, 11, 0.15);
        color: #f59e0b;
    }

    .minimal-badge.status-cancelled {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
    }

    .minimal-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .minimal-btn-primary {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    }

    .minimal-btn-ghost {
        background: transparent;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
    }

    .minimal-btn-icon {
        width: 36px;
        height: 36px;
        padding: 0;
    }

    .minimal-table {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(30, 64, 175, 0.08);
    }

    .minimal-table thead {
        background: linear-gradient(to right, #f8fafc, #f1f5f9);
        border-bottom: 1px solid #e2e8f0;
    }

    .minimal-table thead th {
        padding: 16px 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        border: none;
    }

    .minimal-table tbody td {
        padding: 20px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        font-size: 14px;
    }

    .minimal-table tbody tr:hover {
        background: linear-gradient(to right, rgba(59, 130, 246, 0.02), transparent);
    }
</style>

<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="fw-bold mb-2" style="font-size: 32px; background: linear-gradient(135deg, #1e40af, #3b82f6, #60a5fa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                {{ $project->titre }}
            </h1>
            <div class="d-flex align-items-center gap-2">
                <span class="minimal-badge type">
                    {{ ucfirst($project->type) }}
                </span>
                @php
                    $statusClass = match($project->statut) {
                        'planifié' => 'status-planned',
                        'en_cours' => 'status-in-progress',
                        'terminé' => 'status-completed',
                        'suspendu' => 'status-suspended',
                        'annulé' => 'status-cancelled',
                        default => 'status-planned'
                    };
                @endphp
                <span class="minimal-badge {{ $statusClass }}">
                    {{ ucfirst(str_replace('_', ' ', $project->statut)) }}
                </span>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.projects.edit', $project) }}" class="minimal-btn minimal-btn-ghost">
                <i class="fas fa-edit" style="margin-right: 8px; font-size: 11px;"></i>Modifier
            </a>
            <button type="button" class="minimal-btn minimal-btn-ghost" data-bs-toggle="modal" data-bs-target="#deleteModal" style="color: #ef4444; border-color: #fee2e2;">
                <i class="fas fa-trash" style="margin-right: 8px; font-size: 11px;"></i>Supprimer
            </button>
            <a href="{{ route('admin.projects.index') }}" class="minimal-btn minimal-btn-ghost">
                Retour
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- Main Content --}}
        <div class="col-lg-8">
            {{-- Info Card --}}
            <div class="minimal-card mb-4">
                <h5 style="font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 20px;">Informations Générales</h5>
                
                <div class="row g-4">
                    <div class="col-md-12">
                        <div class="info-row">
                            <div class="info-label">Description</div>
                            <div class="info-value">{{ $project->description }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-row">
                            <div class="info-label">Responsable</div>
                            <div class="info-value">
                                <i class="fas fa-user" style="font-size: 11px; margin-right: 6px; color: #3b82f6;"></i>{{ $project->responsable->name ?? 'Non assigné' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-row">
                            <div class="info-label">Zone</div>
                            <div class="info-value">
                                <i class="fas fa-map-marker-alt" style="font-size: 11px; margin-right: 6px; color: #ef4444;"></i>{{ $project->zone->nom ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-row">
                            <div class="info-label">Infrastructure</div>
                            <div class="info-value">
                                <i class="fas fa-building" style="font-size: 11px; margin-right: 6px; color: #64748b;"></i>{{ $project->infrastructure->nom ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-row">
                            <div class="info-label">Période</div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($project->date_debut)->format('d/m/Y') }} → {{ \Carbon\Carbon::parse($project->date_fin_prevue)->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Phases Table --}}
            <div class="minimal-table mb-4">
                <div style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0;">Phases du Projet</h5>
                        <span class="minimal-badge" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">{{ $project->projectPhases->count() }} phase(s)</span>
                    </div>
                </div>
                
                @if($project->projectPhases->count() > 0)
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Période</th>
                                <th>Coût</th>
                                <th>Avancement</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($project->projectPhases as $phase)
                                <tr>
                                    <td style="font-weight: 600; color: #1e293b;">{{ $phase->nom }}</td>
                                    <td style="font-size: 12px; color: #94a3b8; line-height: 1.6;">
                                        <div>{{ \Carbon\Carbon::parse($phase->date_debut)->format('d/m/Y') }}</div>
                                        <div>{{ \Carbon\Carbon::parse($phase->date_fin)->format('d/m/Y') }}</div>
                                    </td>
                                    <td style="font-weight: 600; color: #1e293b;">{{ number_format($phase->cout / 1000, 0) }}K €</td>
                                    <td>
                                        <div class="minimal-progress-sm" style="width: 80px;">
                                            <div class="minimal-progress-bar-sm" style="width: {{ $phase->avancement }}%"></div>
                                        </div>
                                        <div style="font-size: 11px; color: #64748b; margin-top: 4px;">{{ $phase->avancement }}%</div>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <a href="{{ route('admin.phases.edit', $phase) }}" class="minimal-btn minimal-btn-ghost minimal-btn-icon">
                                                <i class="fas fa-edit" style="font-size: 11px;"></i>
                                            </a>
                                            <form action="{{ route('admin.phases.destroy', $phase) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="minimal-btn minimal-btn-ghost minimal-btn-icon" onclick="if(confirm('Supprimer cette phase ?')) this.closest('form').submit();" style="color: #ef4444; border-color: #fee2e2;">
                                                    <i class="fas fa-trash" style="font-size: 11px;"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center" style="padding: 60px 20px;">
                        <i class="fas fa-tasks" style="font-size: 48px; color: #e2e8f0; margin-bottom: 16px;"></i>
                        <p style="color: #94a3b8; margin-bottom: 16px;">Aucune phase définie.</p>
                        <a href="{{ route('admin.projects.phase.create', $project) }}" class="minimal-btn minimal-btn-primary">
                            <i class="fas fa-plus" style="margin-right: 8px; font-size: 11px;"></i>Ajouter une phase
                        </a>
                    </div>
                @endif
            </div>

            {{-- Financements Table --}}
            <div class="minimal-table mb-4">
                <div style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0;">Financements</h5>
                        <span class="minimal-badge" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">{{ $project->fundings->count() }} source(s)</span>
                    </div>
                </div>
                
                @if($project->fundings->count() > 0)
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Source</th>
                                <th>Type</th>
                                <th>Montant</th>
                                <th>Statut</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($project->fundings as $funding)
                                <tr>
                                    <td style="font-weight: 600; color: #1e293b;">{{ ucfirst($funding->source) }}</td>
                                    <td style="font-size: 13px; color: #64748b;">{{ ucfirst($funding->type) }}</td>
                                    <td style="font-weight: 600; color: #10b981;">{{ number_format($funding->montant / 1000, 0) }}K €</td>
                                    <td>
                                        @php
                                            $fundingBadgeClass = match($funding->statut) {
                                                'en_attente' => 'status-suspended',
                                                'approuvé' => 'status-completed',
                                                'rejeté' => 'status-cancelled',
                                                default => 'status-planned'
                                            };
                                        @endphp
                                        <span class="minimal-badge {{ $fundingBadgeClass }}">{{ ucfirst(str_replace('_', ' ', $funding->statut)) }}</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.fundings.edit', $funding) }}" class="minimal-btn minimal-btn-ghost minimal-btn-icon">
                                            <i class="fas fa-edit" style="font-size: 11px;"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center" style="padding: 60px 20px;">
                        <i class="fas fa-euro-sign" style="font-size: 48px; color: #e2e8f0; margin-bottom: 16px;"></i>
                        <p style="color: #94a3b8; margin-bottom: 16px;">Aucun financement enregistré.</p>
                        <a href="{{ route('admin.projects.funding.create', $project) }}" class="minimal-btn minimal-btn-primary">
                            <i class="fas fa-plus" style="margin-right: 8px; font-size: 11px;"></i>Ajouter un financement
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            {{-- Budget Stats --}}
            <div class="minimal-stat-box">
                <div class="stat-label-sm">Budget Prévu</div>
                <div class="stat-value-lg blue">{{ number_format($project->budget_prevu / 1000, 0) }}K €</div>
            </div>

            <div class="minimal-stat-box">
                <div class="stat-label-sm">Financement Total</div>
                <div class="stat-value-lg green">{{ number_format($project->fundingTotal() / 1000, 0) }}K €</div>
            </div>

            <div class="minimal-stat-box">
                <div class="stat-label-sm">Reste à Financer</div>
                <div class="stat-value-lg amber">{{ number_format(max(0, $project->budget_prevu - $project->fundingTotal()) / 1000, 0) }}K €</div>
                <div class="minimal-progress-sm">
                    <div class="minimal-progress-bar-sm" style="background: linear-gradient(90deg, #10b981, #34d399); width: {{ min(100, ($project->fundingTotal() / max(1, $project->budget_prevu)) * 100) }}%"></div>
                </div>
            </div>

            <div class="minimal-stat-box" style="margin-bottom: 24px;">
                <div class="stat-label-sm">Avancement</div>
                <div class="stat-value-lg cyan">{{ $project->avancement_pourcentage }}%</div>
                <div class="minimal-progress-sm">
                    <div class="minimal-progress-bar-sm" style="width: {{ $project->avancement_pourcentage }}%"></div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="minimal-card">
                <h6 style="font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 16px;">Actions Rapides</h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.projects.phase.create', $project) }}" class="minimal-btn minimal-btn-ghost">
                        <i class="fas fa-plus" style="margin-right: 8px; font-size: 11px;"></i>Ajouter une phase
                    </a>
                    <a href="{{ route('admin.projects.funding.create', $project) }}" class="minimal-btn minimal-btn-ghost">
                        <i class="fas fa-euro-sign" style="margin-right: 8px; font-size: 11px;"></i>Ajouter un financement
                    </a>
                    <a href="{{ route('admin.projects.document.create', $project) }}" class="minimal-btn minimal-btn-ghost">
                        <i class="fas fa-file-upload" style="margin-right: 8px; font-size: 11px;"></i>Ajouter un document
                    </a>
                    <a href="{{ route('admin.projects.edit', $project) }}" class="minimal-btn minimal-btn-ghost">
                        <i class="fas fa-edit" style="margin-right: 8px; font-size: 11px;"></i>Modifier
                    </a>
                    <button type="button" class="minimal-btn minimal-btn-ghost" data-bs-toggle="modal" data-bs-target="#deleteModal" style="color: #ef4444; border-color: #fee2e2;">
                        <i class="fas fa-trash" style="margin-right: 8px; font-size: 11px;"></i>Supprimer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
            <div class="modal-header border-0" style="padding: 24px 24px 16px;">
                <h5 class="modal-title fw-semibold" style="color: #1e293b;">
                    <i class="fas fa-exclamation-triangle" style="color: #ef4444; margin-right: 8px;"></i>Confirmer la suppression
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 16px 24px 24px;">
                <p style="color: #64748b; margin-bottom: 8px;">Êtes-vous sûr de vouloir supprimer le projet <strong style="color: #1e293b;">"{{ $project->titre }}"</strong> ?</p>
                <p style="font-size: 13px; color: #94a3b8; margin-bottom: 0;">Cette action est irréversible.</p>
            </div>
            <div class="modal-footer border-0" style="padding: 0 24px 24px;">
                <button type="button" class="minimal-btn minimal-btn-ghost" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="minimal-btn" style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);">
                        <i class="fas fa-trash" style="margin-right: 8px; font-size: 11px;"></i>Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

</x-project.layouts.admin>
@endsection
