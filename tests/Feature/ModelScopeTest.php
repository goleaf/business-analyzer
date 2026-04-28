<?php

namespace Tests\Feature;

use App\Enums\AiProcessingStatus;
use App\Enums\ContactSubmissionStatus;
use App\Enums\RequestSubmissionStatus;
use App\Models\AiPrompt;
use App\Models\ContactSubmission;
use App\Models\RequestSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelScopeTest extends TestCase
{
    use RefreshDatabase;

    public function test_request_submission_scopes_and_casts(): void
    {
        $older = RequestSubmission::factory()->create([
            'status' => RequestSubmissionStatus::InReview,
            'ai_processing_status' => AiProcessingStatus::Queued,
            'created_at' => now()->subDay(),
        ]);

        $newer = RequestSubmission::factory()->create([
            'status' => RequestSubmissionStatus::Processed,
            'ai_processing_status' => AiProcessingStatus::Prepared,
            'created_at' => now(),
        ]);

        $this->assertSame($newer->id, RequestSubmission::query()->newest()->first()->id);
        $this->assertSame(RequestSubmissionStatus::InReview, $older->refresh()->status);
        $this->assertSame(AiProcessingStatus::Queued, $older->ai_processing_status);

        $selected = RequestSubmission::query()->selectForAdminList()->firstOrFail();

        $this->assertArrayHasKey('business_description', $selected->getAttributes());
        $this->assertArrayHasKey('ai_processing_status', $selected->getAttributes());
    }

    public function test_ai_prompt_scopes_and_casts(): void
    {
        AiPrompt::factory()->create(['name' => 'Third', 'sort_order' => 30]);
        AiPrompt::factory()->create(['name' => 'Second', 'sort_order' => 20]);
        AiPrompt::factory()->create(['name' => 'First', 'sort_order' => 10]);

        $prompts = AiPrompt::query()->ordered()->selectForProcessing()->get();

        $this->assertSame(['First', 'Second', 'Third'], $prompts->pluck('name')->all());
        $this->assertArrayHasKey('prompt', $prompts->first()->getAttributes());
    }

    public function test_contact_submission_scopes_and_casts(): void
    {
        $older = ContactSubmission::factory()->create([
            'status' => ContactSubmissionStatus::Reviewed,
            'created_at' => now()->subDay(),
        ]);

        $newer = ContactSubmission::factory()->create([
            'status' => ContactSubmissionStatus::Archived,
            'created_at' => now(),
        ]);

        $this->assertSame($newer->id, ContactSubmission::query()->newest()->first()->id);
        $this->assertSame(ContactSubmissionStatus::Reviewed, $older->refresh()->status);

        $selected = ContactSubmission::query()->selectForAdminList()->firstOrFail();

        $this->assertArrayHasKey('email_error', $selected->getAttributes());
        $this->assertArrayHasKey('admin_notes', $selected->getAttributes());
    }
}
