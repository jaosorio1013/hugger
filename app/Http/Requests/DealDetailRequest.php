<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealDetailRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'deal_id' => ['required', 'exists:deals'],
            'client_id' => ['required', 'exists:clients'],
            'product_id' => ['required', 'exists:products'],
            'quantity' => ['required', 'integer'],
            'price_per_unit' => ['required', 'numeric'],
            'total' => ['required', 'numeric'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
