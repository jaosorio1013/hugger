<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailchimpCampaignsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'mailchimp_id' => ['required'],
            'name' => ['required'],
            'subject' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
