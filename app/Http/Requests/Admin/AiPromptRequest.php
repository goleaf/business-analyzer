<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AiPromptRequest extends FormRequest
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
        $promptId = $this->route('id') ?? $this->input('id');

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('ai_prompts', 'name')->ignore($promptId)],
            'prompt' => ['required', 'string'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
