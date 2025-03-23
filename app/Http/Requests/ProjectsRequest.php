<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectsRequest extends FormRequest
{
    public function rules(): array
    {
        return $this->isMethod('POST') ? $this->createValidationRules() : $this->updateValidationRules();
    }

    public function updateValidationRules(): array
    {
        return [
            'clients_id' => ['required', 'exists:clients,id'],
            'name' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::enum(Status::class)],
        ];
    }

    public function createValidationRules(): array
    {
        return [
            'clients_id' => ['required', 'exists:clients,id'],
            'name' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::enum(Status::class)],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'clients_id.required' => 'Client is required.',
            'clients_id.exists' => 'Client does not exist.',
            'name.required' => 'Project name is required.',
            'status.required' => 'Project status is required.',
        ];
    }
}
