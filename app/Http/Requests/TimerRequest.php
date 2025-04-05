<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users'],
            'clients_id' => ['required', 'exists:clients'],
            'projects_id' => ['required', 'exists:projects'],
            'duration' => ['required', 'integer'],
            'status' => ['required'],
            'timer' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
