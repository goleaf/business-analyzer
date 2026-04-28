<?php

namespace Tests\Feature;

use App\Filament\Resources\AiPrompts\Pages\CreateAiPrompt;
use App\Filament\Resources\ContactSubmissions\Pages\CreateContactSubmission;
use App\Filament\Resources\RequestSubmissions\Pages\CreateRequestSubmission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentResourceSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_ai_prompt_resource_validates_required_fields(): void
    {
        $this->actingAs($this->adminUser());

        Livewire::test(CreateAiPrompt::class)
            ->fillForm([
                'name' => null,
                'prompt' => null,
                'is_active' => true,
                'sort_order' => 0,
            ])
            ->call('create')
            ->assertHasFormErrors([
                'name' => 'required',
                'prompt' => 'required',
            ]);
    }

    public function test_request_submission_resource_validates_required_fields(): void
    {
        $this->actingAs($this->adminUser());

        Livewire::test(CreateRequestSubmission::class)
            ->fillForm([
                'business_description' => null,
                'achievements' => null,
                'expected_results' => null,
            ])
            ->call('create')
            ->assertHasFormErrors([
                'business_description' => 'required',
                'achievements' => 'required',
                'expected_results' => 'required',
            ]);
    }

    public function test_contact_submission_resource_validates_required_fields(): void
    {
        $this->actingAs($this->adminUser());

        Livewire::test(CreateContactSubmission::class)
            ->fillForm([
                'name' => null,
                'email' => 'not-an-email',
                'message' => null,
            ])
            ->call('create')
            ->assertHasFormErrors([
                'name' => 'required',
                'email' => 'email',
                'message' => 'required',
            ]);
    }

    private function adminUser(): User
    {
        return User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);
    }
}
