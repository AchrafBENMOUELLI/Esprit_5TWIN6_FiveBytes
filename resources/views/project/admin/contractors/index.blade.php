@extends('layouts.admin')

@section('title', 'Gestion des Entrepreneurs')

@section('content')
<x-project.layouts.admin
    title="Gestion des Entrepreneurs"
    :breadcrumbs="[
        ['label' => 'Tableau de bord', 'url' => route('dashboard')],
        ['label' => 'Entrepreneurs', 'url' => null]
    ]">

<style>
    /* Minimalistic Stats Cards */
    .minimal-stat-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        border: none;
        box-shadow: 0 1px 3px rgba(30, 64, 175, 0.08);
        transition: all 0.3s ease;
    }

    .minimal-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(30, 64, 175, 0.12);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 20px;
        margin-bottom: 16px;
    }

    .stat-icon.blue {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(96, 165, 250, 0.15));
        color: #3b82f6;
    }

    .stat-icon.green {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(52, 211, 153, 0.15));
        color: #10b981;
    }

    .stat-icon.cyan {
        background: linear-gradient(135deg, rgba(6, 182, 212, 0.1), rgba(34, 211, 238, 0.15));
        color: #06b6d4;
    }

    .stat-icon.amber {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(251, 191, 36, 0.15));
        color: #f59e0b;
    }

    .stat-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
        margin-bottom: 4px;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #1e293b;
        line-height: 1;
    }

    /* Minimalistic Table */
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

    .minimal-table tbody tr:last-child td {
        border-bottom: none;
    }

    .minimal-table tbody tr {
        transition: background 0.2s ease;
    }

    .minimal-table tbody tr:hover {
        background: linear-gradient(to right, rgba(59, 130, 246, 0.02), transparent);
    }

    /* Minimalistic Badges */
    .minimal-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.025em;
    }

    .minimal-badge.specialty {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
        color: #6366f1;
    }

    .minimal-badge.active {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(52, 211, 153, 0.15));
        color: #10b981;
    }

    /* Minimalistic Buttons */
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
        cursor: pointer;
    }

    .minimal-btn-primary {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    }

    .minimal-btn-primary:hover {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .minimal-btn-ghost {
        background: transparent;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
    }

    .minimal-btn-ghost:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #475569;
    }

    .minimal-btn-icon {
        width: 36px;
        height: 36px;
        padding: 0;
        background: transparent;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
    }

    .minimal-btn-icon:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #3b82f6;
    }

    /* Filters */
    .minimal-filter-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(30, 64, 175, 0.08);
    }

    .minimal-input {
        padding: 10px 16px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .minimal-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
</style>

<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="fw-bold mb-2" style="font-size: 32px; background: linear-gradient(135deg, #1e40af, #3b82f6, #60a5fa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                Entrepreneurs
            </h1>
            <p class="text-muted mb-0" style="font-size: 15px;">Gérez les entreprises et prestataires pour vos projets</p>
        </div>
        <a href="{{ route('admin.contractors.create') }}" class="minimal-btn minimal-btn-primary" style="padding: 12px 24px; font-size: 14px;">
            <i class="fas fa-plus" style="margin-right: 8px; font-size: 12px;"></i>Nouveau Entrepreneur
        </a>
    </div>

    {{-- Messages Flash --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border-left: 4px solid #10b981;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border-left: 4px solid #ef4444;">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Stats --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="minimal-stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stat-label">Total Entrepreneurs</div>
                <div class="stat-value">{{ $contractors->total() }}</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="minimal-stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-label">Actifs</div>
                <div class="stat-value">{{ $contractors->filter(fn($c) => $c->projectPhases->count() > 0)->count() }}</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="minimal-stat-card">
                <div class="stat-icon cyan">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-label">Phases Totales</div>
                <div class="stat-value">{{ $contractors->sum(fn($c) => $c->projectPhases->count()) }}</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="minimal-stat-card">
                <div class="stat-icon amber">
                    <i class="fas fa-wrench"></i>
                </div>
                <div class="stat-label">Spécialités</div>
                <div class="stat-value">{{ $contractors->pluck('specialite')->unique()->count() }}</div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="minimal-filter-card mb-4">
        <form method="GET" action="{{ route('admin.contractors.index') }}" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label" style="font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 8px;">Recherche</label>
                <input type="text" class="minimal-input w-100" name="search" placeholder="Nom de l'entrepreneur..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label" style="font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 8px;">Spécialité</label>
                <input type="text" class="minimal-input w-100" name="specialite" placeholder="Ex: plomberie, électricité..." value="{{ request('specialite') }}">
            </div>
            <div class="col-md-3">
                <div class="d-flex gap-2">
                    <button type="submit" class="minimal-btn minimal-btn-primary flex-grow-1">
                        <i class="fas fa-search" style="margin-right: 8px; font-size: 12px;"></i>Filtrer
                    </button>
                    @if(request()->hasAny(['search', 'specialite']))
                        <a href="{{ route('admin.contractors.index') }}" class="minimal-btn minimal-btn-icon">
                            <i class="fas fa-redo" style="font-size: 12px;"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="minimal-table">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width: 25%;">Entrepreneur</th>
                    <th style="width: 15%;">Spécialité</th>
                    <th style="width: 20%;">Contact</th>
                    <th style="width: 25%;">Adresse</th>
                    <th style="width: 10%;" class="text-center">Phases</th>
                    <th style="width: 5%;" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contractors as $contractor)
                    <tr>
                        <td>
                            <div style="font-weight: 600; color: #1e293b;">{{ $contractor->nom }}</div>
                        </td>
                        <td>
                            <span class="minimal-badge specialty">
                                <i class="fas fa-tools" style="font-size: 10px; margin-right: 6px;"></i>{{ ucfirst($contractor->specialite) }}
                            </span>
                        </td>
                        <td>
                            <div style="font-size: 13px; color: #64748b; line-height: 1.6;">
                                @if($contractor->telephone)
                                    <div>
                                        <i class="fas fa-phone" style="font-size: 10px; margin-right: 6px; color: #3b82f6;"></i>
                                        <a href="tel:{{ $contractor->telephone }}" style="color: inherit; text-decoration: none;">{{ $contractor->telephone }}</a>
                                    </div>
                                @endif
                                @if($contractor->email)
                                    <div class="text-truncate" style="max-width: 200px;">
                                        <i class="fas fa-envelope" style="font-size: 10px; margin-right: 6px; color: #94a3b8;"></i>
                                        <a href="mailto:{{ $contractor->email }}" style="color: inherit; text-decoration: none;">{{ $contractor->email }}</a>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div style="font-size: 13px; color: #64748b;">
                                <i class="fas fa-map-marker-alt" style="font-size: 10px; margin-right: 6px; color: #ef4444;"></i>{{ Str::limit($contractor->adresse ?? 'Non renseignée', 50) }}
                            </div>
                        </td>
                        <td class="text-center">
                            @php
                                $phasesCount = $contractor->projectPhases->count();
                            @endphp
                            @if($phasesCount > 0)
                                <span class="minimal-badge active">{{ $phasesCount }}</span>
                            @else
                                <span style="color: #cbd5e1;">-</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex gap-1 justify-content-end">
                                <a href="{{ route('admin.contractors.show', $contractor) }}" class="minimal-btn minimal-btn-icon" title="Voir">
                                    <i class="fas fa-eye" style="font-size: 11px;"></i>
                                </a>
                                <a href="{{ route('admin.contractors.edit', $contractor) }}" class="minimal-btn minimal-btn-icon" title="Modifier">
                                    <i class="fas fa-edit" style="font-size: 11px;"></i>
                                </a>
                                <button type="button" class="minimal-btn minimal-btn-icon" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $contractor->id }}" title="Supprimer" style="color: #ef4444; border-color: #fee2e2;">
                                    <i class="fas fa-trash" style="font-size: 11px;"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center" style="padding: 60px 20px;">
                            <i class="fas fa-building" style="font-size: 48px; color: #e2e8f0; margin-bottom: 16px;"></i>
                            <p style="color: #94a3b8; margin-bottom: 16px;">Aucun entrepreneur trouvé.</p>
                            <a href="{{ route('admin.contractors.create') }}" class="minimal-btn minimal-btn-primary">
                                <i class="fas fa-plus" style="margin-right: 8px; font-size: 11px;"></i>Ajouter le premier entrepreneur
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($contractors->hasPages())
            <div style="padding: 20px; border-top: 1px solid #f1f5f9;">
                {{ $contractors->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

{{-- Delete Modals --}}
@foreach($contractors as $contractor)
<div class="modal fade" id="deleteModal{{ $contractor->id }}" tabindex="-1">
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
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>

</x-project.layouts.admin>
@endsection
