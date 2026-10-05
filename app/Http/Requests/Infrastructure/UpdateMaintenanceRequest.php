<?php

namespace App\Http\Requests\Infrastructure;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaintenanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'infrastructure_id'  => ['required', 'exists:infrastructures,id'],
            'technicien_id'      => ['required', 'exists:users,id'],
            'type'               => ['required', 'in:preventive,corrective,urgence'],
            'description'        => ['required', 'string', 'max:1000'],
            'date_intervention'  => ['required', 'date'],
            'cout'               => ['required', 'numeric', 'min:0'],
            'statut'             => ['required', 'in:planifiee,en_cours,terminee,annulee'],
        ];
    }

    public function messages(): array
    {
        return [
            'infrastructure_id.required' => 'L\'infrastructure est obligatoire.',
            'infrastructure_id.exists'   => 'L\'infrastructure sélectionnée n\'existe pas.',
            'technicien_id.required'     => 'Le technicien est obligatoire.',
            'technicien_id.exists'       => 'Le technicien sélectionné n\'existe pas.',
            'type.required'              => 'Le type est obligatoire.',
            'type.in'                    => 'Le type sélectionné est invalide.',
            'description.required'       => 'La description est obligatoire.',
            'description.max'            => 'La description ne peut pas dépasser 1000 caractères.',
            'date_intervention.required' => 'La date d\'intervention est obligatoire.',
            'date_intervention.date'     => 'La date d\'intervention est invalide.',
            'cout.required'              => 'Le coût est obligatoire.',
            'cout.min'                   => 'Le coût ne peut pas être négatif.',
            'statut.required'            => 'Le statut est obligatoire.',
            'statut.in'                  => 'Le statut sélectionné est invalide.',
        ];
    }
}
