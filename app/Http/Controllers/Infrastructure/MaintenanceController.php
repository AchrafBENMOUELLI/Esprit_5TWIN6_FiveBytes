<?php

namespace App\Http\Controllers\Infrastructure;

use App\Http\Controllers\Controller;
use App\Http\Requests\Infrastructure\StoreMaintenanceRequest;
use App\Http\Requests\Infrastructure\UpdateMaintenanceRequest;
use App\Models\Infrastructure\Infrastructure;
use App\Models\Infrastructure\Maintenance;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaintenanceController extends Controller
{
    public function index(Request $request): View
    {
        $query = Maintenance::with(['infrastructure', 'technicien']);

        if ($request->filled('infrastructure_id')) {
            $query->where('infrastructure_id', $request->input('infrastructure_id'));
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->input('statut'));
        }

        $maintenances = $query->latest()->paginate(10)->withQueryString();
        $infrastructures = Infrastructure::orderBy('nom')->get();

        return view('components.infrastructure.maintenances.index', compact('maintenances', 'infrastructures'));
    }

    public function create(): View
    {
        $infrastructures = Infrastructure::orderBy('nom')->get();
        $techniciens = User::orderBy('name')->get();

        return view('components.infrastructure.maintenances.create', compact('infrastructures', 'techniciens'));
    }

    public function store(StoreMaintenanceRequest $request): RedirectResponse
    {
        Maintenance::create($request->validated());

        return redirect()
            ->route('admin.infrastructure.maintenances.index')
            ->with('success', 'Maintenance créée avec succès.');
    }

    public function show(Maintenance $maintenance): View
    {
        $maintenance->load(['infrastructure.zone', 'technicien']);

        return view('components.infrastructure.maintenances.show', compact('maintenance'));
    }

    public function edit(Maintenance $maintenance): View
    {
        $infrastructures = Infrastructure::orderBy('nom')->get();
        $techniciens = User::orderBy('name')->get();

        return view('components.infrastructure.maintenances.edit', compact('maintenance', 'infrastructures', 'techniciens'));
    }

    public function update(UpdateMaintenanceRequest $request, Maintenance $maintenance): RedirectResponse
    {
        $maintenance->update($request->validated());

        return redirect()
            ->route('admin.infrastructure.maintenances.index')
            ->with('success', 'Maintenance mise à jour avec succès.');
    }

    public function destroy(Maintenance $maintenance): RedirectResponse
    {
        $maintenance->delete();

        return redirect()
            ->route('admin.infrastructure.maintenances.index')
            ->with('success', 'Maintenance supprimée avec succès.');
    }
}
