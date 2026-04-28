<?php

namespace App\Http\Requests\Admin;

use App\Enums\ContactSubmissionStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactSubmissionRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'message' => ['required', 'string'],
            'status' => ['required', Rule::enum(ContactSubmissionStatus::class)],
            'admin_notes' => ['nullable', 'string'],
        ];
    }
}
