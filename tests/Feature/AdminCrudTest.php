<?php

namespace Tests\Feature;

use App\Enums\AiProcessingStatus;
use App\Jobs\ProcessRequestSubmissionData;
use App\Models\AiPrompt;
use App\Models\RequestSubmission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_request_submission_admin_list_is_available(): void
    {
        $admin = User::factory()->create();
        RequestSubmission::factory()->create([
            'business_description' => 'A saved request visible to admins.',
        ]);

        $this->actingAs($admin, 'backpack')
            ->get('/admin/request-submissions')
            ->assertOk()
            ->assertSee('Business description preview');
    }

    public function test_process_data_route_dispatches_job_for_saved_submission(): void
    {
        Queue::fake();

        $admin = User::factory()->create();
        $submission = RequestSubmission::factory()->create();

        $this->actingAs($admin, 'backpack')
            ->post(route('request-submissions.process-data', $submission))
            ->assertRedirect();

        $this->assertDatabaseHas('request_submissions', [
            'id' => $submission->id,
            'ai_processing_status' => AiProcessingStatus::Queued->value,
        ]);

        Queue::assertPushed(ProcessRequestSubmissionData::class, function (ProcessRequestSubmissionData $job) use ($submission): bool {
            return $job->requestSubmission->is($submission);
        });
    }

    public function test_ai_prompts_are_database_records_and_admin_list_is_available(): void
    {
        $admin = User::factory()->create();

        AiPrompt::factory()->create([
            'name' => 'Growth analysis prompt',
            'prompt' => 'Analyze the saved request data.',
            'is_active' => true,
            'sort_order' => 10,
        ]);

        $this->assertDatabaseHas('ai_prompts', [
            'name' => 'Growth analysis prompt',
            'prompt' => 'Analyze the saved request data.',
            'is_active' => true,
            'sort_order' => 10,
        ]);

        $this->actingAs($admin, 'backpack')
            ->get('/admin/ai-prompts')
            ->assertOk()
            ->assertSee('Prompt preview');
    }
}
