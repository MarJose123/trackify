<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'company_name' => ['required', 'unique:clients,company_name'],
            'name' => ['required', 'string'],
            'currency' => ['required'],
            'billing_method' => ['required'],
            'status' => ['required'],
            'rate' => ['required', 'numeric'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
