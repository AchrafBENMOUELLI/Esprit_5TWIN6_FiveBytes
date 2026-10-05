<?php

namespace App\Http\Controllers\Quality;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quality\ThresholdRequest;
use App\Models\Quality\Threshold;
use App\Services\Quality\ThresholdService;

class ThresholdController extends Controller
{
    public function __construct(private ThresholdService $service) {}

    public function index()
    {
        $thresholds = Threshold::orderBy('parametre')->paginate(15);

        return view('quality.thresholds.index', compact('thresholds'));
    }

    public function create()
    {
        return view('quality.thresholds.create');
    }

    public function store(ThresholdRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()->route('admin.quality.thresholds.index')
            ->with('success', 'Seuil créé avec succès.');
    }

    public function show(Threshold $threshold)
    {
        $threshold->load(['parameters.sample']);

        return view('quality.thresholds.show', compact('threshold'));
    }

    public function edit(Threshold $threshold)
    {
        return view('quality.thresholds.edit', compact('threshold'));
    }

    public function update(ThresholdRequest $request, Threshold $threshold)
    {
        $this->service->update($threshold, $request->validated());

        return redirect()->route('admin.quality.thresholds.index')
            ->with('success', 'Seuil mis à jour avec succès.');
    }

    public function destroy(Threshold $threshold)
    {
        if ($threshold->parameters()->exists()) {
            return back()->with('error', 'Impossible de supprimer un seuil utilisé dans des analyses.');
        }

        $threshold->delete();

        return back()->with('success', 'Seuil supprimé avec succès.');
    }
}
