<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'nit' => ['nullable'],
            'phone' => ['nullable'],
            'address' => ['nullable'],
            'type' => ['required', 'integer'],
            'user_id' => ['nullable', 'exists:users'],
            'crm_font_id' => ['nullable', 'exists:crm_fonts'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
