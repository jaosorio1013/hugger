<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrmActionStateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
