<?php

namespace App\Http\Requests;

use App\Enums\IncidentStatut;
use App\Enums\IncidentType;
use App\Enums\IncidentUrgence;
use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreIncidentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // L'autorisation est gérée par la Policy
    }

    /**
     * Prepare the data for validation.
     * Filtre les champs selon le rôle de l'utilisateur.
     */
    protected function prepareForValidation(): void
    {
        $user = $this->user();
        
        // Si l'utilisateur est un citoyen, on force citoyen_id et on supprime les champs réservés
        if ($user && $user->role === UserRole::Citoyen) {
            // Le citoyen ne peut pas définir ces champs
            $this->merge([
                'citoyen_id' => $user->id,
                'statut' => IncidentStatut::Nouveau->value,
            ]);
            
            // Supprimer les champs non autorisés pour un citoyen
            $this->request->remove('technicien_id');
            $this->request->remove('incident_parent_id');
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->user();
        $isGestionnaireOrAdmin = $user && in_array($user->role, [UserRole::Gestionnaire, UserRole::Admin]);

        $rules = [
            'type' => ['required', Rule::enum(IncidentType::class)],
            'description' => ['required', 'string', 'min:10', 'max:5000'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'urgence' => ['required', Rule::enum(IncidentUrgence::class)],
            'infrastructure_id' => ['nullable', 'exists:infrastructures,id'],
            'citoyen_id' => ['required', 'exists:users,id'], // Obligatoire pour tous
        ];

        // Champs réservés aux gestionnaires et admins
        if ($isGestionnaireOrAdmin) {
            $rules['statut'] = ['sometimes', Rule::enum(IncidentStatut::class)];
            $rules['technicien_id'] = ['nullable', 'exists:users,id'];
            $rules['incident_parent_id'] = ['nullable', 'exists:incidents,id'];
        }

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'type' => 'type d\'incident',
            'description' => 'description',
            'latitude' => 'latitude',
            'longitude' => 'longitude',
            'urgence' => 'niveau d\'urgence',
            'statut' => 'statut',
            'citoyen_id' => 'citoyen',
            'technicien_id' => 'technicien',
            'infrastructure_id' => 'infrastructure',
            'incident_parent_id' => 'incident parent',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'type.required' => 'Le type d\'incident est obligatoire.',
            'type.enum' => 'Le type d\'incident sélectionné est invalide.',
            'description.required' => 'La description est obligatoire.',
            'description.min' => 'La description doit contenir au moins :min caractères.',
            'description.max' => 'La description ne peut pas dépasser :max caractères.',
            'latitude.required' => 'La latitude est obligatoire.',
            'latitude.numeric' => 'La latitude doit être un nombre.',
            'latitude.between' => 'La latitude doit être comprise entre -90 et 90.',
            'longitude.required' => 'La longitude est obligatoire.',
            'longitude.numeric' => 'La longitude doit être un nombre.',
            'longitude.between' => 'La longitude doit être comprise entre -180 et 180.',
            'urgence.required' => 'Le niveau d\'urgence est obligatoire.',
            'urgence.enum' => 'Le niveau d\'urgence sélectionné est invalide.',
            'statut.enum' => 'Le statut sélectionné est invalide.',
            'citoyen_id.required' => 'Le citoyen est obligatoire.',
            'citoyen_id.exists' => 'Le citoyen sélectionné n\'existe pas.',
            'technicien_id.exists' => 'Le technicien sélectionné n\'existe pas.',
            'infrastructure_id.exists' => 'L\'infrastructure sélectionnée n\'existe pas.',
            'incident_parent_id.exists' => 'L\'incident parent sélectionné n\'existe pas.',
        ];
    }
}
