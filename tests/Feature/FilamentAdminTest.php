<?php

namespace Tests\Feature;

use App\Enums\AiProcessingStatus;
use App\Filament\Resources\AiPrompts\AiPromptResource;
use App\Filament\Resources\AiPrompts\Pages\CreateAiPrompt;
use App\Filament\Resources\AiPrompts\Pages\ListAiPrompts;
use App\Filament\Resources\ContactSubmissions\ContactSubmissionResource;
use App\Filament\Resources\RequestSubmissions\Pages\ListRequestSubmissions;
use App\Filament\Resources\RequestSubmissions\RequestSubmissionResource;
use App\Jobs\ProcessRequestSubmissionData;
use App\Models\AiPrompt;
use App\Models\ContactSubmission;
use App\Models\RequestSubmission;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_configured_admin_can_open_filament_panel_and_resource_lists(): void
    {
        $admin = $this->adminUser();

        RequestSubmission::factory()->create([
            'business_description' => 'A saved request visible to admins.',
        ]);
        ContactSubmission::factory()->create([
            'email' => 'contact@example.com',
        ]);
        AiPrompt::factory()->create([
            'name' => 'Growth analysis prompt',
        ]);

        $this->actingAs($admin)
            ->get('/admin')
            ->assertOk();

        $this->actingAs($admin)
            ->get(RequestSubmissionResource::getUrl('index'))
            ->assertOk()
            ->assertSee('Business description preview');

        $this->actingAs($admin)
            ->get(ContactSubmissionResource::getUrl('index'))
            ->assertOk()
            ->assertSee('Contact Submissions');

        $this->actingAs($admin)
            ->get(AiPromptResource::getUrl('index'))
            ->assertOk()
            ->assertSee('Prompt preview');
    }

    public function test_unconfigured_user_cannot_open_filament_panel(): void
    {
        $this->actingAs(User::factory()->create(['email' => 'user@example.com']))
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_process_data_action_dispatches_job_for_saved_submission(): void
    {
        Queue::fake();

        $this->actingAs($this->adminUser());

        $submission = RequestSubmission::factory()->create([
            'ai_processing_status' => AiProcessingStatus::NotStarted,
        ]);

        Livewire::test(ListRequestSubmissions::class)
            ->callAction(TestAction::make('processData')->table($submission))
            ->assertNotified();

        $this->assertDatabaseHas('request_submissions', [
            'id' => $submission->id,
            'ai_processing_status' => AiProcessingStatus::Queued->value,
        ]);

        Queue::assertPushed(ProcessRequestSubmissionData::class, function (ProcessRequestSubmissionData $job) use ($submission): bool {
            return $job->requestSubmission->is($submission);
        });
    }

    public function test_ai_prompts_are_created_through_filament_resource(): void
    {
        $this->actingAs($this->adminUser());

        Livewire::test(CreateAiPrompt::class)
            ->fillForm([
                'name' => 'Market Positioning',
                'prompt' => 'Analyze market positioning from saved request data.',
                'is_active' => true,
                'sort_order' => 5,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('ai_prompts', [
            'name' => 'Market Positioning',
            'prompt' => 'Analyze market positioning from saved request data.',
            'is_active' => true,
            'sort_order' => 5,
        ]);
    }

    public function test_ai_prompt_list_uses_database_records(): void
    {
        $this->actingAs($this->adminUser());

        AiPrompt::factory()->create([
            'name' => 'Database stored prompt',
            'prompt' => 'Stored prompt text.',
        ]);

        Livewire::test(ListAiPrompts::class)
            ->assertCanSeeTableRecords(AiPrompt::query()->where('name', 'Database stored prompt')->get());
    }

    private function adminUser(): User
    {
        return User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);
    }
}
