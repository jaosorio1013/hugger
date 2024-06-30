<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => ['required'],
            'client_name' => ['nullable'],
            'date' => ['nullable', 'date'],
            'total' => ['nullable', 'numeric'],
            'client_id' => ['required', 'exists:clients'],
            'client_contact_id' => ['nullable', 'exists:client_contacts'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
