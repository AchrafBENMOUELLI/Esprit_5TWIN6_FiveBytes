<?php

namespace App\Http\Requests\Infrastructure;

use Illuminate\Foundation\Http\FormRequest;

class UpdateZoneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom'         => ['required', 'string', 'max:100'],
            'commune'     => ['required', 'string', 'max:100'],
            'code_postal' => ['required', 'string', 'max:10', 'regex:/^[0-9]{4,10}$/'],
            'population'  => ['required', 'integer', 'min:0'],
            'latitude'    => ['required', 'numeric', 'between:-90,90'],
            'longitude'   => ['required', 'numeric', 'between:-180,180'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required'         => 'Le nom est obligatoire.',
            'commune.required'     => 'La commune est obligatoire.',
            'code_postal.required' => 'Le code postal est obligatoire.',
            'code_postal.regex'    => 'Le code postal doit contenir entre 4 et 10 chiffres.',
            'population.required'  => 'La population est obligatoire.',
            'population.integer'   => 'La population doit être un nombre entier.',
            'population.min'       => 'La population ne peut pas être négative.',
            'latitude.required'    => 'La latitude est obligatoire.',
            'latitude.between'     => 'La latitude doit être comprise entre -90 et 90.',
            'longitude.required'   => 'La longitude est obligatoire.',
            'longitude.between'    => 'La longitude doit être comprise entre -180 et 180.',
        ];
    }
}
