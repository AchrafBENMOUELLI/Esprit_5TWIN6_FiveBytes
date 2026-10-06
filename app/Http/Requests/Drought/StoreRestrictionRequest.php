<?php

namespace App\Http\Requests\Drought;

use Illuminate\Foundation\Http\FormRequest;

class StoreRestrictionRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Allow any authenticated user to manage restrictions (for testing/development)
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'titre' => 'required|string|max:255',
            'niveau' => 'required|in:vigilance,alerte,crise',
            'description' => 'required|string|max:1000',
            'date_debut' => 'required|date_format:Y-m-d H:i|after_or_equal:now',
            'date_fin' => 'nullable|date_format:Y-m-d H:i|after:date_debut',
            'zone_id' => 'required|exists:zones,id',
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre est obligatoire.',
            'niveau.required' => 'Le niveau de restriction est obligatoire.',
            'description.required' => 'La description est obligatoire.',
            'date_debut.required' => 'La date de début est obligatoire.',
            'date_debut.after_or_equal' => 'La date de début doit être dans le futur.',
            'date_fin.after' => 'La date de fin doit être après la date de début.',
            'zone_id.required' => 'La zone est obligatoire.',
            'zone_id.exists' => 'La zone sélectionnée n\'existe pas.',
        ];
    }
}
