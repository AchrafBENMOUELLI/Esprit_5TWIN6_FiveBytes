<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncidentPhotoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // L'autorisation est gérée par la Policy
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'photos' => ['nullable', 'array', 'max:5'],
            'photos.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'], // 4 Mo
            'legende' => ['nullable', 'string', 'max:255'],
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
            'photos.array' => 'Le champ photos doit être un tableau.',
            'photos.max' => 'Vous ne pouvez télécharger que :max photos maximum.',
            'photos.*.required' => 'Chaque photo est requise.',
            'photos.*.image' => 'Le fichier doit être une image.',
            'photos.*.mimes' => 'Les formats autorisés sont : jpg, jpeg, png, webp.',
            'photos.*.max' => 'Chaque photo ne doit pas dépasser :max Ko (4 Mo).',
            'legende.string' => 'La légende doit être une chaîne de caractères.',
            'legende.max' => 'La légende ne doit pas dépasser :max caractères.',
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
            'photos' => 'photos',
            'photos.*' => 'photo',
            'legende' => 'légende',
        ];
    }
}
