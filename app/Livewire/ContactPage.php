<?php

namespace App\Livewire;

use App\Actions\SendContactSubmissionNotificationAction;
use App\Models\ContactSubmission;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Contact')]
class ContactPage extends Component
{
    public string $name = '';

    public string $email = '';

    public string $message = '';

    /**
     * @return array<string, list<string>>
     */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'message' => ['required', 'string'],
        ];
    }

    public function submit(SendContactSubmissionNotificationAction $notificationAction): void
    {
        $submission = ContactSubmission::create($this->validate());

        $notificationAction->handle($submission);

        $this->reset(['name', 'email', 'message']);

        session()->flash('status', 'Your message has been sent.');
    }

    public function render(): View
    {
        return view('livewire.contact-page');
    }
}
