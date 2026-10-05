<?php

namespace App\Http\Controllers\Infrastructure;

use App\Http\Controllers\Controller;
use App\Http\Requests\Infrastructure\StoreInfrastructureRequest;
use App\Http\Requests\Infrastructure\UpdateInfrastructureRequest;
use App\Models\Infrastructure\Infrastructure;
use App\Models\Infrastructure\Zone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InfrastructureController extends Controller
{
    public function index(Request $request): View
    {
        $query = Infrastructure::with('zone');

        if ($request->filled('zone_id')) {
            $query->where('zone_id', $request->input('zone_id'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('materiau', 'like', "%{$search}%");
            });
        }

        $infrastructures = $query->latest()->paginate(10)->withQueryString();
        $zones = Zone::orderBy('nom')->get();

        return view('components.infrastructure.infrastructures.index', compact('infrastructures', 'zones'));
    }

    public function create(): View
    {
        $zones = Zone::orderBy('nom')->get();

        return view('components.infrastructure.infrastructures.create', compact('zones'));
    }

    public function store(StoreInfrastructureRequest $request): RedirectResponse
    {
        Infrastructure::create($request->validated());

        return redirect()
            ->route('admin.infrastructure.infrastructures.index')
            ->with('success', 'Infrastructure créée avec succès.');
    }

    public function show(Infrastructure $infrastructure): View
    {
        $infrastructure->load(['zone', 'maintenances.technicien']);

        return view('components.infrastructure.infrastructures.show', compact('infrastructure'));
    }

    public function edit(Infrastructure $infrastructure): View
    {
        $zones = Zone::orderBy('nom')->get();

        return view('components.infrastructure.infrastructures.edit', compact('infrastructure', 'zones'));
    }

    public function update(UpdateInfrastructureRequest $request, Infrastructure $infrastructure): RedirectResponse
    {
        $infrastructure->update($request->validated());

        return redirect()
            ->route('admin.infrastructure.infrastructures.index')
            ->with('success', 'Infrastructure mise à jour avec succès.');
    }

    public function destroy(Infrastructure $infrastructure): RedirectResponse
    {
        $infrastructure->delete();

        return redirect()
            ->route('admin.infrastructure.infrastructures.index')
            ->with('success', 'Infrastructure supprimée avec succès.');
    }
}
