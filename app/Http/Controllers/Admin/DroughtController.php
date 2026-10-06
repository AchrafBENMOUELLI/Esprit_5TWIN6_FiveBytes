<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Drought\StoreRestrictionRequest;
use App\Http\Requests\Drought\StoreWaterLevelRequest;
use App\Http\Requests\Drought\StoreConsumptionReadingRequest;
use App\Models\Drought\Restriction;
use App\Models\Drought\WaterLevel;
use App\Models\Drought\ConsumptionReading;
use App\Models\Drought\ScheduledCut;
use App\Models\Infrastructure\Zone;
use Illuminate\Http\Request;

class DroughtController extends Controller
{
    // === Restrictions ===
    public function indexRestrictions()
    {
        $restrictions = Restriction::with(['zone', 'createur'])->latest()->paginate(10);
        return view('admin.drought.restrictions.index', compact('restrictions'));
    }

    public function createRestriction()
    {
        $zones = Zone::all();
        return view('admin.drought.restrictions.create', compact('zones'));
    }

    public function storeRestriction(StoreRestrictionRequest $request)
    {
        $data = $request->validated();
        $data['cree_par'] = auth()->id();
        
        Restriction::create($data);
        return redirect()->route('admin.drought.restrictions.index')->with('success', 'Restriction créée avec succès.');
    }

    public function showRestriction(Restriction $restriction)
    {
        $restriction->load(['zone', 'createur', 'cuts']);
        return view('admin.drought.restrictions.show', compact('restriction'));
    }

    public function editRestriction(Restriction $restriction)
    {
        $zones = Zone::all();
        return view('admin.drought.restrictions.edit', compact('restriction', 'zones'));
    }

    public function updateRestriction(StoreRestrictionRequest $request, Restriction $restriction)
    {
        $data = $request->validated();
        $data['cree_par'] = auth()->id();
        
        $restriction->update($data);
        return redirect()->route('admin.drought.restrictions.index')->with('success', 'Restriction mise à jour.');
    }

    public function destroyRestriction(Restriction $restriction)
    {
        $restriction->delete();
        return redirect()->route('admin.drought.restrictions.index')->with('success', 'Restriction supprimée.');
    }

    // === Water Levels ===
    public function indexWaterLevels()
    {
        $waterLevels = WaterLevel::with('zone')->latest('date_releve')->paginate(10);
        return view('admin.drought.water_levels.index', compact('waterLevels'));
    }

    public function createWaterLevel()
    {
        $zones = Zone::all();
        return view('admin.drought.water_levels.create', compact('zones'));
    }

    public function storeWaterLevel(StoreWaterLevelRequest $request)
    {
        WaterLevel::create($request->validated());
        return redirect()->route('admin.drought.water-levels.index')->with('success', 'Niveau d\'eau enregistré.');
    }

    public function showWaterLevel(WaterLevel $waterLevel)
    {
        $waterLevel->load('zone');
        return view('admin.drought.water_levels.show', compact('waterLevel'));
    }

    public function editWaterLevel(WaterLevel $waterLevel)
    {
        $zones = Zone::all();
        return view('admin.drought.water_levels.edit', compact('waterLevel', 'zones'));
    }

    public function updateWaterLevel(StoreWaterLevelRequest $request, WaterLevel $waterLevel)
    {
        $waterLevel->update($request->validated());
        return redirect()->route('admin.drought.water-levels.index')->with('success', 'Niveau d\'eau mis à jour.');
    }

    public function destroyWaterLevel(WaterLevel $waterLevel)
    {
        $waterLevel->delete();
        return redirect()->route('admin.drought.water-levels.index')->with('success', 'Niveau d\'eau supprimé.');
    }

    // === Consumption Readings ===
    public function indexConsumption()
    {
        $readings = ConsumptionReading::with('zone')->latest('periode_debut')->paginate(10);
        return view('admin.drought.consumption.index', compact('readings'));
    }

    public function createConsumption()
    {
        $zones = Zone::all();
        return view('admin.drought.consumption.create', compact('zones'));
    }

    public function storeConsumption(StoreConsumptionReadingRequest $request)
    {
        ConsumptionReading::create($request->validated());
        return redirect()->route('admin.drought.consumption.index')->with('success', 'Lecture de consommation enregistrée.');
    }

    public function showConsumption(ConsumptionReading $consumption)
    {
        $consumption->load('zone');
        return view('admin.drought.consumption.show', compact('consumption'));
    }

    public function editConsumption(ConsumptionReading $consumption)
    {
        $zones = Zone::all();
        return view('admin.drought.consumption.edit', compact('consumption', 'zones'));
    }

    public function updateConsumption(StoreConsumptionReadingRequest $request, ConsumptionReading $consumption)
    {
        $consumption->update($request->validated());
        return redirect()->route('admin.drought.consumption.index')->with('success', 'Lecture mise à jour.');
    }

    public function destroyConsumption(ConsumptionReading $consumption)
    {
        $consumption->delete();
        return redirect()->route('admin.drought.consumption.index')->with('success', 'Lecture supprimée.');
    }

    // === Scheduled Cuts ===
    public function indexScheduledCuts()
    {
        $cuts = ScheduledCut::with(['restriction', 'zone'])->latest('debut')->paginate(10);
        return view('admin.drought.scheduled_cuts.index', compact('cuts'));
    }

    public function createScheduledCut()
    {
        $restrictions = Restriction::all();
        $zones = Zone::all();
        return view('admin.drought.scheduled_cuts.create', compact('restrictions', 'zones'));
    }

    public function storeScheduledCut(Request $request)
    {
        $validated = $request->validate([
            'restriction_id' => 'required|exists:restrictions,id',
            'zone_id' => 'required|exists:zones,id',
            'debut' => 'required|date_format:Y-m-d H:i',
            'fin' => 'required|date_format:Y-m-d H:i|after:debut',
            'motif' => 'nullable|string|max:500',
        ]);

        ScheduledCut::create($validated);
        return redirect()->route('admin.drought.scheduled-cuts.index')->with('success', 'Coupure planifiée créée.');
    }

    public function showScheduledCut(ScheduledCut $cut)
    {
        $cut->load(['restriction', 'zone']);
        return view('admin.drought.scheduled_cuts.show', compact('cut'));
    }

    public function editScheduledCut(ScheduledCut $cut)
    {
        $restrictions = Restriction::all();
        $zones = Zone::all();
        return view('admin.drought.scheduled_cuts.edit', compact('cut', 'restrictions', 'zones'));
    }

    public function updateScheduledCut(Request $request, ScheduledCut $cut)
    {
        $validated = $request->validate([
            'restriction_id' => 'required|exists:restrictions,id',
            'zone_id' => 'required|exists:zones,id',
            'debut' => 'required|date_format:Y-m-d H:i',
            'fin' => 'required|date_format:Y-m-d H:i|after:debut',
            'motif' => 'nullable|string|max:500',
        ]);

        $cut->update($validated);
        return redirect()->route('admin.drought.scheduled-cuts.index')->with('success', 'Coupure mise à jour.');
    }

    public function destroyScheduledCut(ScheduledCut $cut)
    {
        $cut->delete();
        return redirect()->route('admin.drought.scheduled-cuts.index')->with('success', 'Coupure supprimée.');
    }
}
