<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientContactRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['nullable', 'email', 'max:254'],
            'charge' => ['nullable'],
            'phone' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
