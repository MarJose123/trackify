<?php

namespace App\Http\Requests;

use App\Models\Clients;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
{
    public function rules(): array
    {
        return $this->isMethod('POST') ? $this->creationValidationRules() : $this->updateValidationRules();
    }

    protected function updateValidationRules(): array
    {
        return [
            'company_name' => ['required', Rule::unique('clients')->ignore($this->route('client'))],
            'name' => ['required', 'string'],
            'currency' => ['required'],
            'billing_method' => ['required'],
            'status' => ['required'],
            'rate' => ['required', 'numeric'],
        ];
    }

    protected function creationValidationRules(): array
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
