<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreFundingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_id' => ['required', 'exists:projects,id'],
            'source' => ['required', 'in:municipal,régional,fédéral,européen,privé,don'],
            'donateur_id' => ['required_if:source,don', 'nullable', 'exists:users,id'],
            'montant' => ['required', 'numeric', 'min:1'],
            'date_versement' => ['required', 'date'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // Project
            'project_id.required' => 'Le projet est obligatoire.',
            'project_id.exists' => 'Le projet sélectionné n\'existe pas.',
            
            // Source
            'source.required' => 'La source de financement est obligatoire.',
            'source.in' => 'La source doit être : municipal, régional, fédéral, européen, privé ou don.',
            
            // Donateur
            'donateur_id.required_if' => 'Le donateur est obligatoire pour un don.',
            'donateur_id.exists' => 'Le donateur sélectionné n\'existe pas.',
            
            // Montant
            'montant.required' => 'Le montant est obligatoire.',
            'montant.numeric' => 'Le montant doit être un nombre.',
            'montant.min' => 'Le montant doit être au minimum :min €.',
            
            // Date versement
            'date_versement.required' => 'La date de versement est obligatoire.',
            'date_versement.date' => 'La date de versement doit être une date valide.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'project_id' => 'projet',
            'source' => 'source de financement',
            'donateur_id' => 'donateur',
            'montant' => 'montant',
            'date_versement' => 'date de versement',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Vérification supplémentaire : si source n'est pas 'don', donateur_id doit être null
            if ($this->source !== 'don' && $this->donateur_id !== null) {
                $validator->errors()->add('donateur_id', 'Un donateur ne peut être spécifié que pour un don.');
            }
        });
    }
}
