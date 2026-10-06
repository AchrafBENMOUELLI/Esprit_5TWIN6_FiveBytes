<?php

namespace App\Http\Requests\Drought;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'zone_id' => 'required|exists:zones,id',
            'canal' => 'required|in:email,sms,app',
        ];
    }

    public function messages(): array
    {
        return [
            'zone_id.required' => 'La zone est obligatoire.',
            'canal.required' => 'Le canal de notification est obligatoire.',
        ];
    }
}
