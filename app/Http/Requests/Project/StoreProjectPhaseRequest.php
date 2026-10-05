<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectPhaseRequest extends FormRequest
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
            'contractor_id' => ['required', 'exists:contractors,id'],
            'nom' => ['required', 'string', 'max:150'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date', 'after:date_debut'],
            'cout' => ['required', 'numeric', 'min:0'],
            'avancement' => ['nullable', 'integer', 'min:0', 'max:100'],
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
            
            // Contractor
            'contractor_id.required' => 'Le prestataire est obligatoire.',
            'contractor_id.exists' => 'Le prestataire sélectionné n\'existe pas.',
            
            // Nom
            'nom.required' => 'Le nom de la phase est obligatoire.',
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'nom.max' => 'Le nom ne peut pas dépasser :max caractères.',
            
            // Date début
            'date_debut.required' => 'La date de début est obligatoire.',
            'date_debut.date' => 'La date de début doit être une date valide.',
            
            // Date fin
            'date_fin.required' => 'La date de fin est obligatoire.',
            'date_fin.date' => 'La date de fin doit être une date valide.',
            'date_fin.after' => 'La date de fin doit être après la date de début.',
            
            // Coût
            'cout.required' => 'Le coût est obligatoire.',
            'cout.numeric' => 'Le coût doit être un nombre.',
            'cout.min' => 'Le coût doit être supérieur ou égal à :min €.',
            
            // Avancement
            'avancement.integer' => 'L\'avancement doit être un nombre entier.',
            'avancement.min' => 'L\'avancement doit être au minimum :min%.',
            'avancement.max' => 'L\'avancement ne peut pas dépasser :max%.',
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
            'contractor_id' => 'prestataire',
            'nom' => 'nom de la phase',
            'date_debut' => 'date de début',
            'date_fin' => 'date de fin',
            'cout' => 'coût',
            'avancement' => 'avancement',
        ];
    }
}
