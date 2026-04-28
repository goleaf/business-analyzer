<?php

namespace App\Http\Requests\Admin;

use App\Enums\RequestSubmissionStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RequestSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'business_description' => ['required', 'string'],
            'achievements' => ['required', 'string'],
            'expected_results' => ['required', 'string'],
            'status' => ['required', Rule::enum(RequestSubmissionStatus::class)],
            'admin_notes' => ['nullable', 'string'],
        ];
    }
}
