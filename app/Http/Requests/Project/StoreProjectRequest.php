<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'titre' => ['required', 'string', 'max:200'],
            'type' => ['required', 'in:réparation,modernisation,extension,construction'],
            'description' => ['required', 'string'],
            'budget_prevu' => ['required', 'numeric', 'min:0', 'max:10000000'],
            'date_debut' => ['required', 'date', 'after_or_equal:today'],
            'date_fin_prevue' => ['required', 'date', 'after:date_debut'],
            'statut' => ['required', 'in:planifié,en_cours,suspendu,terminé,annulé'],
            'avancement_pourcentage' => ['nullable', 'integer', 'min:0', 'max:100'],
            'zone_id' => ['required', 'exists:zones,id'],
            'infrastructure_id' => ['nullable', 'exists:infrastructures,id'],
            'responsable_id' => ['required', 'exists:users,id'],
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
            // Titre
            'titre.required' => 'Le titre du projet est obligatoire.',
            'titre.string' => 'Le titre doit être une chaîne de caractères.',
            'titre.max' => 'Le titre ne peut pas dépasser :max caractères.',
            
            // Type
            'type.required' => 'Le type de projet est obligatoire.',
            'type.in' => 'Le type doit être : réparation, modernisation, extension ou construction.',
            
            // Description
            'description.required' => 'La description du projet est obligatoire.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            
            // Budget
            'budget_prevu.required' => 'Le budget prévu est obligatoire.',
            'budget_prevu.numeric' => 'Le budget doit être un nombre.',
            'budget_prevu.min' => 'Le budget doit être supérieur ou égal à :min €.',
            'budget_prevu.max' => 'Le budget ne peut pas dépasser :max €.',
            
            // Date début
            'date_debut.required' => 'La date de début est obligatoire.',
            'date_debut.date' => 'La date de début doit être une date valide.',
            'date_debut.after_or_equal' => 'La date de début doit être aujourd\'hui ou dans le futur.',
            
            // Date fin prévue
            'date_fin_prevue.required' => 'La date de fin prévue est obligatoire.',
            'date_fin_prevue.date' => 'La date de fin prévue doit être une date valide.',
            'date_fin_prevue.after' => 'La date de fin doit être après la date de début.',
            
            // Statut
            'statut.required' => 'Le statut du projet est obligatoire.',
            'statut.in' => 'Le statut doit être : planifié, en_cours, suspendu, terminé ou annulé.',
            
            // Avancement
            'avancement_pourcentage.integer' => 'L\'avancement doit être un nombre entier.',
            'avancement_pourcentage.min' => 'L\'avancement doit être au minimum :min%.',
            'avancement_pourcentage.max' => 'L\'avancement ne peut pas dépasser :max%.',
            
            // Zone
            'zone_id.required' => 'La zone est obligatoire.',
            'zone_id.exists' => 'La zone sélectionnée n\'existe pas.',
            
            // Infrastructure
            'infrastructure_id.exists' => 'L\'infrastructure sélectionnée n\'existe pas.',
            'responsable_id.required' => 'Le responsable du projet est obligatoire.',
            'responsable_id.exists' => 'Le responsable sélectionné n\'existe pas.',
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
            'titre' => 'titre',
            'type' => 'type',
            'description' => 'description',
            'budget_prevu' => 'budget prévu',
            'date_debut' => 'date de début',
            'date_fin_prevue' => 'date de fin prévue',
            'statut' => 'statut',
            'avancement_pourcentage' => 'avancement',
            'zone_id' => 'zone',
            'infrastructure_id' => 'infrastructure',
            'responsable_id' => 'responsable',
        ];
    }
}
