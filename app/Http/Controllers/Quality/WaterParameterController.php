<?php

namespace App\Http\Controllers\Quality;

use App\Http\Controllers\Controller;
use App\Models\Quality\WaterParameter;
use App\Models\Quality\WaterSample;

class WaterParameterController extends Controller
{
    public function index(WaterSample $sample)
    {
        $parameters = $sample->parameters()
            ->with('threshold')
            ->get();

        return view('quality.parameters.index', compact('sample', 'parameters'));
    }

    public function show(WaterParameter $parameter)
    {
        $parameter->load(['sample', 'threshold']);

        return view('quality.parameters.show', compact('parameter'));
    }
}
