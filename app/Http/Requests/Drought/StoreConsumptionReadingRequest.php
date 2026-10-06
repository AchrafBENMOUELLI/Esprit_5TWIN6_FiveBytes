<?php

namespace App\Http\Requests\Drought;

use Illuminate\Foundation\Http\FormRequest;

class StoreConsumptionReadingRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Allow any authenticated user to manage consumption readings (for testing/development)
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'zone_id' => 'required|exists:zones,id',
            'volume_m3' => 'required|numeric|min:0',
            'periode_debut' => 'required|date_format:Y-m-d\TH:i',
            'periode_fin' => 'required|date_format:Y-m-d\TH:i|after:periode_debut',
            'prevision_ia' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'zone_id.required' => 'La zone est obligatoire.',
            'volume_m3.required' => 'Le volume en m³ est obligatoire.',
            'periode_debut.required' => 'La date de début est obligatoire.',
            'periode_fin.required' => 'La date de fin est obligatoire.',
            'periode_fin.after' => 'La date de fin doit être après la date de début.',
        ];
    }
}
