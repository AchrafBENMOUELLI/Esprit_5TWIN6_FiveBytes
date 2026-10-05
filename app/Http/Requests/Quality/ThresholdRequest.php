<?php

namespace App\Http\Requests\Quality;

use App\Enums\Quality\AlertLevel;
use App\Enums\Quality\QualityParameter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ThresholdRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'parametre' => ['required', Rule::enum(QualityParameter::class)],
            'unite' => ['required', 'string', 'max:20'],
            'valeur_min' => ['nullable', 'numeric', 'min:0'],
            'valeur_max' => ['nullable', 'numeric', 'min:0', 'gt:valeur_min'],
            'niveau_alerte' => ['required', Rule::enum(AlertLevel::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'valeur_max.gt' => 'La valeur maximale doit être supérieure à la valeur minimale.',
        ];
    }
}
