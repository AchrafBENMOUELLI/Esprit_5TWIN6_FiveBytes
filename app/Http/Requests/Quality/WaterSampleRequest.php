<?php

namespace App\Http\Requests\Quality;

use Illuminate\Foundation\Http\FormRequest;

class WaterSampleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // ignore les paramètres dont la valeur est vide
        $this->merge([
            'parameters' => collect($this->input('parameters', []))
                ->filter(fn ($p) => ($p['valeur'] ?? '') !== '')
                ->values()
                ->all(),
        ]);
    }

    public function rules(): array
    {
        return [
            'zone_id' => ['required', 'exists:zones,id'],
            'infrastructure_id' => ['nullable', 'exists:infrastructures,id'],
            'date_prelevement' => ['required', 'date', 'before_or_equal:now'],
            'parameters' => ['required', 'array', 'min:1'],
            'parameters.*.threshold_id' => ['required', 'distinct', 'exists:thresholds,id'],
            'parameters.*.valeur' => ['required', 'numeric'],
        ];
    }
}
