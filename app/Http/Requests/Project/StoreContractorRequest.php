<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractorRequest extends FormRequest
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
            'nom' => ['required', 'string', 'max:100', 'unique:contractors,nom'],
            'specialite' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:contractors,email'],
            'telephone' => ['required', 'string', 'regex:/^(\+33\s?|0)[1-9](\s?\d{2}){4}$/'],
            'adresse' => ['required', 'string'],
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
            // Nom
            'nom.required' => 'Le nom de l\'entreprise est obligatoire.',
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'nom.max' => 'Le nom ne peut pas dépasser :max caractères.',
            'nom.unique' => 'Ce nom d\'entreprise est déjà utilisé.',
            
            // Spécialité
            'specialite.required' => 'La spécialité est obligatoire.',
            'specialite.string' => 'La spécialité doit être une chaîne de caractères.',
            'specialite.max' => 'La spécialité ne peut pas dépasser :max caractères.',
            
            // Email
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            
            // Téléphone
            'telephone.required' => 'Le numéro de téléphone est obligatoire.',
            'telephone.string' => 'Le numéro de téléphone doit être une chaîne de caractères.',
            'telephone.regex' => 'Le format du numéro de téléphone est invalide. Formats acceptés : +33612345678, +33 6 12 34 56 78, 0612345678 ou 06 12 34 56 78.',
            
            // Adresse
            'adresse.required' => 'L\'adresse est obligatoire.',
            'adresse.string' => 'L\'adresse doit être une chaîne de caractères.',
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
            'nom' => 'nom de l\'entreprise',
            'specialite' => 'spécialité',
            'email' => 'adresse email',
            'telephone' => 'numéro de téléphone',
            'adresse' => 'adresse',
        ];
    }
}
