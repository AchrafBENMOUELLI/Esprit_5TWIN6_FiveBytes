<?php

namespace App\Http\Requests\Quality;

use Illuminate\Foundation\Http\FormRequest;

class QualityAlertRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'message' => ['sometimes', 'string', 'max:1000'],
            'publiee' => ['sometimes', 'boolean'],
        ];
    }
}
