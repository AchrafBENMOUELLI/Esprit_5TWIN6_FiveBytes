<?php

namespace App\Http\Requests\Drought;

use Illuminate\Foundation\Http\FormRequest;

class StoreWaterLevelRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Allow any authenticated user to manage water levels (for testing/development)
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'zone_id' => 'required|exists:zones,id',
            'source' => 'required|in:reservoir,nappe,barrage',
            'niveau_pourcentage' => 'required|numeric|between:0,100',
            'volume_m3' => 'required|numeric|min:0',
            'date_releve' => 'required|date_format:Y-m-d\TH:i|before_or_equal:now',
        ];
    }

    public function messages(): array
    {
        return [
            'zone_id.required' => 'La zone est obligatoire.',
            'source.required' => 'La source est obligatoire.',
            'niveau_pourcentage.required' => 'Le niveau en pourcentage est obligatoire.',
            'niveau_pourcentage.between' => 'Le niveau doit être entre 0 et 100.',
            'volume_m3.required' => 'Le volume en m³ est obligatoire.',
            'date_releve.required' => 'La date du relevé est obligatoire.',
        ];
    }
}
