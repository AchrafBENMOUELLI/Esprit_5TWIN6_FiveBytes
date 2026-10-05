<?php

namespace App\Http\Controllers\Quality;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quality\QualityAlertRequest;
use App\Models\Quality\QualityAlert;
use App\Services\Quality\QualityAlertService;

class QualityAlertController extends Controller
{
    public function __construct(private QualityAlertService $service) {}

    public function index()
    {
        $alerts = QualityAlert::with(['sample.zone'])
            ->whereNull('date_resolution')
            ->latest()
            ->paginate(15);

        return view('quality.alerts.index', compact('alerts'));
    }

    public function show(QualityAlert $alert)
    {
        $alert->load(['sample.zone', 'sample.infrastructure', 'sample.preleveur', 'sample.parameters.threshold']);

        return view('quality.alerts.show', compact('alert'));
    }

    public function update(QualityAlertRequest $request, QualityAlert $alert)
    {
        $this->service->update($alert, $request->validated());

        return back()->with('success', 'Alerte mise à jour avec succès.');
    }

    public function resolve(QualityAlert $alert)
    {
        $this->service->resolve($alert);

        return back()->with('success', 'Alerte résolue avec succès.');
    }

    public function publish(QualityAlert $alert)
    {
        $this->service->publish($alert);

        return back()->with('success', 'Alerte publiée avec succès.');
    }

    public function destroy(QualityAlert $alert)
    {
        $alert->delete();

        return back()->with('success', 'Alerte supprimée avec succès.');
    }
}
