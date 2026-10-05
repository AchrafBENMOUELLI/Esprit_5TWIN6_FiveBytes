<?php

namespace App\Http\Controllers\Quality;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quality\WaterSampleRequest;
use App\Models\Infrastructure\Infrastructure;
use App\Models\Infrastructure\Zone;
use App\Models\Quality\Threshold;
use App\Models\Quality\WaterSample;
use App\Services\Quality\WaterSampleService;

class WaterSampleController extends Controller
{
    public function __construct(private WaterSampleService $service) {}

    public function index()
    {
        $samples = WaterSample::with(['zone', 'preleveur'])
            ->latest('date_prelevement')
            ->paginate(15);
            
        return view('dashboard', [
            'module' => 'quality',
            'samples' => $samples,
        ]);
    }

    public function create()
    {
        return view('quality.samples.create', [
            'zones' => Zone::all(),
            'infrastructures' => Infrastructure::all(),
            'thresholds' => Threshold::all(),
        ]);
    }

    public function store(WaterSampleRequest $request)
    {
        $this->service->store($request->validated(), $request->user()->id);

        return redirect()->route('admin.quality.samples.index')
            ->with('success', 'Analyse enregistrée.');
    }

    public function show(WaterSample $sample)
    {
        $sample->load(['zone', 'infrastructure', 'preleveur', 'parameters.threshold', 'alerts']);

        return view('quality.samples.show', compact('sample'));
    }

    public function edit(WaterSample $sample)
    {
        $sample->load(['parameters']);

        return view('quality.samples.edit', [
            'sample' => $sample,
            'zones' => Zone::all(),
            'infrastructures' => Infrastructure::all(),
            'thresholds' => Threshold::all(),
        ]);
    }

    public function update(WaterSampleRequest $request, WaterSample $sample)
    {
        $this->service->update($sample, $request->validated());

        return redirect()->route('admin.quality.samples.index')
            ->with('success', 'Analyse mise à jour.');
    }

    public function destroy(WaterSample $sample)
    {
        $sample->delete();

        return back()->with('success', 'Analyse supprimée.');
    }
}
