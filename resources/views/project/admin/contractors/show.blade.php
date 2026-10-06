@extends('layouts.admin')

@section('title', $contractor->nom)

@section('content')
<x-project.layouts.admin
    :title="$contractor->nom"
    :breadcrumbs="[
        ['label' => 'Tableau de bord', 'url' => route('dashboard')],
        ['label' => 'Entrepreneurs', 'url' => route('admin.contractors.index')],
        ['label' => $contractor->nom, 'url' => null]
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

    .minimal-badge.specialty {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
        color: #6366f1;
    }

    .minimal-badge.active {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(52, 211, 153, 0.15));
        color: #10b981;
    }

    .minimal-badge.inactive {
        background: rgba(100, 116, 139, 0.1);
        color: #64748b;
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
                {{ $contractor->nom }}
            </h1>
            <div class="d-flex align-items-center gap-2">
                <span class="minimal-badge specialty">
                    <i class="fas fa-tools" style="font-size: 10px; margin-right: 6px;"></i>{{ ucfirst($contractor->specialite) }}
                </span>
                @if($contractor->projectPhases->count() > 0)
                    <span class="minimal-badge active">
                        <i class="fas fa-check-circle" style="font-size: 10px; margin-right: 6px;"></i>Actif
                    </span>
                @else
                    <span class="minimal-badge inactive">
                        <i class="fas fa-pause-circle" style="font-size: 10px; margin-right: 6px;"></i>Inactif
                    </span>
                @endif
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.contractors.edit', $contractor) }}" class="minimal-btn minimal-btn-ghost">
                <i class="fas fa-edit" style="margin-right: 8px; font-size: 11px;"></i>Modifier
            </a>
            <button type="button" class="minimal-btn minimal-btn-ghost" data-bs-toggle="modal" data-bs-target="#deleteModal" style="color: #ef4444; border-color: #fee2e2;">
                <i class="fas fa-trash" style="margin-right: 8px; font-size: 11px;"></i>Supprimer
            </button>
            <a href="{{ route('admin.contractors.index') }}" class="minimal-btn minimal-btn-ghost">
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
                    <div class="col-md-6">
                        <div class="info-row">
                            <div class="info-label">Nom de l'entreprise</div>
                            <div class="info-value">{{ $contractor->nom }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-row">
                            <div class="info-label">Spécialité</div>
                            <div class="info-value">{{ ucfirst($contractor->specialite) }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-row">
                            <div class="info-label">Téléphone</div>
                            <div class="info-value">
                                <a href="tel:{{ $contractor->telephone }}" style="color: #3b82f6; text-decoration: none;">
                                    <i class="fas fa-phone" style="font-size: 11px; margin-right: 6px;"></i>{{ $contractor->telephone }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-row">
                            <div class="info-label">Email</div>
                            <div class="info-value">
                                <a href="mailto:{{ $contractor->email }}" style="color: #3b82f6; text-decoration: none;">
                                    <i class="fas fa-envelope" style="font-size: 11px; margin-right: 6px;"></i>{{ $contractor->email }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="info-row">
                            <div class="info-label">Adresse</div>
                            <div class="info-value">
                                <i class="fas fa-map-marker-alt" style="font-size: 11px; margin-right: 6px; color: #ef4444;"></i>{{ $contractor->adresse }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Phases Table --}}
            <div class="minimal-table">
                <div style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0;">Phases Assignées</h5>
                        <span class="minimal-badge" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">{{ $contractor->projectPhases->count() }} phase(s)</span>
                    </div>
                </div>
                
                @if($contractor->projectPhases->count() > 0)
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Projet</th>
                                <th>Phase</th>
                                <th>Période</th>
                                <th>Coût</th>
                                <th>Avancement</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contractor->projectPhases as $phase)
                                <tr>
                                    <td>
                                        <div style="font-weight: 600; color: #1e293b; margin-bottom: 4px;">{{ $phase->project->titre }}</div>
                                        <span class="minimal-badge" style="font-size: 10px; padding: 4px 8px; background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                                            {{ ucfirst(str_replace('_', ' ', $phase->project->statut)) }}
                                        </span>
                                    </td>
                                    <td style="font-weight: 500; color: #64748b;">{{ $phase->nom }}</td>
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
                                        <a href="{{ route('admin.projects.show', $phase->project) }}" class="minimal-btn minimal-btn-ghost minimal-btn-icon">
                                            <i class="fas fa-external-link-alt" style="font-size: 11px;"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center" style="padding: 60px 20px;">
                        <i class="fas fa-tasks" style="font-size: 48px; color: #e2e8f0; margin-bottom: 16px;"></i>
                        <p style="color: #94a3b8; margin-bottom: 16px;">Aucune phase assignée.</p>
                        <a href="{{ route('admin.projects.index') }}" class="minimal-btn minimal-btn-primary">
                            <i class="fas fa-project-diagram" style="margin-right: 8px; font-size: 11px;"></i>Voir les projets
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            {{-- Stats --}}
            <div class="minimal-stat-box">
                <div class="stat-label-sm">Phases Actives</div>
                <div class="stat-value-lg blue">{{ $contractor->projectPhases->count() }}</div>
            </div>

            <div class="minimal-stat-box">
                <div class="stat-label-sm">Projets Distincts</div>
                <div class="stat-value-lg cyan">{{ $contractor->projectPhases->pluck('project_id')->unique()->count() }}</div>
            </div>

            <div class="minimal-stat-box">
                <div class="stat-label-sm">Montant Total</div>
                <div class="stat-value-lg green">{{ number_format($contractor->projectPhases->sum('cout') / 1000, 0) }}K €</div>
            </div>

            <div class="minimal-stat-box" style="margin-bottom: 24px;">
                <div class="stat-label-sm">Avancement Moyen</div>
                @php
                    $avgProgress = $contractor->projectPhases->count() > 0 ? $contractor->projectPhases->avg('avancement') : 0;
                @endphp
                <div class="stat-value-lg amber">{{ number_format($avgProgress, 0) }}%</div>
                <div class="minimal-progress-sm">
                    <div class="minimal-progress-bar-sm" style="background: linear-gradient(90deg, #f59e0b, #fbbf24); width: {{ $avgProgress }}%"></div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="minimal-card">
                <h6 style="font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 16px;">Actions Rapides</h6>
                <div class="d-grid gap-2">
                    <a href="mailto:{{ $contractor->email }}" class="minimal-btn minimal-btn-ghost">
                        <i class="fas fa-envelope" style="margin-right: 8px; font-size: 11px;"></i>Envoyer un email
                    </a>
                    <a href="tel:{{ $contractor->telephone }}" class="minimal-btn minimal-btn-ghost">
                        <i class="fas fa-phone" style="margin-right: 8px; font-size: 11px;"></i>Appeler
                    </a>
                    <a href="{{ route('admin.contractors.edit', $contractor) }}" class="minimal-btn minimal-btn-ghost">
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
                <p style="color: #64748b; margin-bottom: 8px;">Êtes-vous sûr de vouloir supprimer cet entrepreneur ?</p>
                <div style="background: rgba(245, 158, 11, 0.1); border-left: 4px solid #f59e0b; padding: 12px; border-radius: 8px; margin-bottom: 12px;">
                    <strong style="color: #1e293b;">{{ $contractor->nom }}</strong>
                    @if($contractor->projectPhases->count() > 0)
                        <div style="font-size: 13px; color: #dc2626; margin-top: 4px;">
                            <i class="fas fa-exclamation-triangle" style="font-size: 11px; margin-right: 4px;"></i>
                            Cet entrepreneur est assigné à {{ $contractor->projectPhases->count() }} phase(s).
                        </div>
                    @endif
                </div>
                <p style="font-size: 13px; color: #94a3b8; margin-bottom: 0;">Cette action est irréversible.</p>
            </div>
            <div class="modal-footer border-0" style="padding: 0 24px 24px;">
                <button type="button" class="minimal-btn minimal-btn-ghost" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('admin.contractors.destroy', $contractor) }}" method="POST" style="display: inline;">
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
