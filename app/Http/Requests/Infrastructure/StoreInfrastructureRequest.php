<?php

namespace App\Http\Requests\Infrastructure;

use Illuminate\Foundation\Http\FormRequest;

class StoreInfrastructureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom'               => ['required', 'string', 'max:150'],
            'type'              => ['required', 'in:canalisation,reservoir,station_pompage,captage,compteur'],
            'materiau'          => ['required', 'string', 'max:100'],
            'date_installation' => ['required', 'date', 'before_or_equal:today'],
            'capacite'          => ['required', 'numeric', 'min:0'],
            'latitude'          => ['required', 'numeric', 'between:-90,90'],
            'longitude'         => ['required', 'numeric', 'between:-180,180'],
            'statut'            => ['required', 'in:operationnel,maintenance,hors_service'],
            'score_risque'      => ['nullable', 'numeric', 'between:0,100'],
            'zone_id'           => ['required', 'exists:zones,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required'               => 'Le nom est obligatoire.',
            'type.required'              => 'Le type est obligatoire.',
            'type.in'                    => 'Le type sélectionné est invalide.',
            'materiau.required'          => 'Le matériau est obligatoire.',
            'date_installation.required' => 'La date d\'installation est obligatoire.',
            'date_installation.before_or_equal' => 'La date d\'installation ne peut pas être dans le futur.',
            'capacite.required'          => 'La capacité est obligatoire.',
            'capacite.min'               => 'La capacité ne peut pas être négative.',
            'latitude.between'           => 'La latitude doit être comprise entre -90 et 90.',
            'longitude.between'          => 'La longitude doit être comprise entre -180 et 180.',
            'statut.required'            => 'Le statut est obligatoire.',
            'statut.in'                  => 'Le statut sélectionné est invalide.',
            'score_risque.between'       => 'Le score de risque doit être compris entre 0 et 100.',
            'zone_id.required'           => 'La zone est obligatoire.',
            'zone_id.exists'             => 'La zone sélectionnée n\'existe pas.',
        ];
    }
}
