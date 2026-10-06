<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;

class StoreIncidentCommentRequest extends FormRequest
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
     * Force interne à false pour les citoyens.
     */
    protected function prepareForValidation(): void
    {
        $user = $this->user();
        
        // Si l'utilisateur est un citoyen, forcer interne à false
        if ($user && $user->role === UserRole::Citoyen) {
            $this->merge([
                'interne' => false,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'contenu' => ['required', 'string', 'min:3', 'max:2000'],
            'interne' => ['nullable', 'boolean'],
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
            'contenu' => 'contenu du commentaire',
            'interne' => 'commentaire interne',
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
            'contenu.required' => 'Le contenu du commentaire est obligatoire.',
            'contenu.string' => 'Le contenu doit être une chaîne de caractères.',
            'contenu.min' => 'Le contenu doit contenir au moins :min caractères.',
            'contenu.max' => 'Le contenu ne peut pas dépasser :max caractères.',
            'interne.boolean' => 'Le champ commentaire interne doit être vrai ou faux.',
        ];
    }
}
