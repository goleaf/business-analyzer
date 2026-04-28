<?php

namespace App\Livewire;

use App\Models\RequestSubmission;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Request')]
class RequestPage extends Component
{
    public string $business_description = '';

    public string $achievements = '';

    public string $expected_results = '';

    /**
     * @return array<string, list<string>>
     */
    protected function rules(): array
    {
        return [
            'business_description' => ['required', 'string'],
            'achievements' => ['required', 'string'],
            'expected_results' => ['required', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function validationAttributes(): array
    {
        return [
            'business_description' => 'business description',
            'achievements' => 'achievements',
            'expected_results' => 'expected results',
        ];
    }

    public function submit(): void
    {
        $validated = $this->validate();

        RequestSubmission::create($validated);

        $this->reset(['business_description', 'achievements', 'expected_results']);

        session()->flash('status', 'Your request has been submitted.');
    }

    public function render(): View
    {
        return view('livewire.request-page');
    }
}
