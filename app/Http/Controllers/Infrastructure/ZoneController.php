<?php

namespace App\Http\Controllers\Infrastructure;

use App\Http\Controllers\Controller;
use App\Http\Requests\Infrastructure\StoreZoneRequest;
use App\Http\Requests\Infrastructure\UpdateZoneRequest;
use App\Models\Infrastructure\Zone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ZoneController extends Controller
{
    public function index(Request $request): View
    {
        $query = Zone::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('commune', 'like', "%{$search}%")
                  ->orWhere('code_postal', 'like', "%{$search}%");
            });
        }

        $zones = $query->latest()->paginate(10)->withQueryString();

        return view('components.infrastructure.zones.index', compact('zones'));
    }

    public function create(): View
    {
        return view('components.infrastructure.zones.create');
    }

    public function store(StoreZoneRequest $request): RedirectResponse
    {
        Zone::create($request->validated());

        return redirect()
            ->route('admin.infrastructure.zones.index')
            ->with('success', 'Zone créée avec succès.');
    }

    public function show(Zone $zone): View
    {
        $zone->load('infrastructures');

        return view('components.infrastructure.zones.show', compact('zone'));
    }

    public function edit(Zone $zone): View
    {
        return view('components.infrastructure.zones.edit', compact('zone'));
    }

    public function update(UpdateZoneRequest $request, Zone $zone): RedirectResponse
    {
        $zone->update($request->validated());

        return redirect()
            ->route('admin.infrastructure.zones.index')
            ->with('success', 'Zone mise à jour avec succès.');
    }

    public function destroy(Zone $zone): RedirectResponse
    {
        $zone->delete();

        return redirect()
            ->route('admin.infrastructure.zones.index')
            ->with('success', 'Zone supprimée avec succès.');
    }
}
