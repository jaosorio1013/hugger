<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientActionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'client_id' => ['required', 'exists:clients'],
            'crm_action_id' => ['required', 'exists:crm_actions'],
            'crm_action_state_id' => ['required', 'exists:crm_states'],
            'notes' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
