<?php

namespace Tests\Feature;

use App\Actions\PrepareRequestSubmissionAiProcessingAction;
use App\Actions\SendContactSubmissionNotificationAction;
use App\Ai\RequestSubmissionAiContext;
use App\Enums\AiProcessingStatus;
use App\Enums\ContactSubmissionStatus;
use App\Enums\RequestSubmissionStatus;
use App\Jobs\ProcessRequestSubmissionData;
use App\Mail\ContactSubmissionReceived;
use App\Models\AiPrompt;
use App\Models\ContactSubmission;
use App\Models\RequestSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Mockery;
use RuntimeException;
use Tests\TestCase;

class AppLayerBehaviorTest extends TestCase
{
    use RefreshDatabase;

    public function test_enum_options_are_english_labels(): void
    {
        $this->assertSame('Queued', AiProcessingStatus::Queued->label());
        $this->assertSame('Reviewed', ContactSubmissionStatus::Reviewed->label());
        $this->assertSame('In review', RequestSubmissionStatus::InReview->label());

        $this->assertSame('Prepared', AiProcessingStatus::options()['prepared']);
        $this->assertSame('Archived', ContactSubmissionStatus::options()['archived']);
        $this->assertSame('Processed', RequestSubmissionStatus::options()['processed']);
    }

    public function test_ai_context_maps_saved_request_and_prompt_records(): void
    {
        $submission = RequestSubmission::factory()->create([
            'business_description' => 'Business context',
            'achievements' => 'Business achievements',
            'expected_results' => 'Expected business results',
        ]);

        $prompts = AiPrompt::factory()->count(2)->sequence(
            ['name' => 'First prompt', 'prompt' => 'Prompt one', 'sort_order' => 10],
            ['name' => 'Second prompt', 'prompt' => 'Prompt two', 'sort_order' => 20],
        )->create();

        $context = RequestSubmissionAiContext::from($submission, $prompts);

        $this->assertSame($submission->id, $context->requestSubmissionId);
        $this->assertSame('Business context', $context->businessDescription);
        $this->assertSame('Business achievements', $context->achievements);
        $this->assertSame('Expected business results', $context->expectedResults);
        $this->assertSame(['First prompt', 'Second prompt'], collect($context->prompts)->pluck('name')->all());
    }

    public function test_prepare_request_submission_ai_processing_uses_active_prompts_only(): void
    {
        $submission = RequestSubmission::factory()->create();

        AiPrompt::factory()->create(['name' => 'Second active', 'is_active' => true, 'sort_order' => 20]);
        AiPrompt::factory()->create(['name' => 'Inactive', 'is_active' => false, 'sort_order' => 5]);
        AiPrompt::factory()->create(['name' => 'First active', 'is_active' => true, 'sort_order' => 10]);

        $context = app(PrepareRequestSubmissionAiProcessingAction::class)->handle($submission);

        $this->assertSame(['First active', 'Second active'], collect($context->prompts)->pluck('name')->all());

        $submission->refresh();

        $this->assertSame(AiProcessingStatus::Prepared, $submission->ai_processing_status);
        $this->assertNotNull($submission->ai_processing_started_at);
        $this->assertNotNull($submission->ai_processing_completed_at);
        $this->assertNull($submission->ai_processing_error);
    }

    public function test_contact_notification_action_marks_successful_email(): void
    {
        Mail::fake();
        config(['business_analyzer.admin_email' => 'admin@example.com']);

        $submission = ContactSubmission::factory()->create();

        app(SendContactSubmissionNotificationAction::class)->handle($submission);

        Mail::assertSent(ContactSubmissionReceived::class, function (ContactSubmissionReceived $mail): bool {
            return $mail->hasTo('admin@example.com');
        });

        $this->assertNotNull($submission->refresh()->email_sent_at);
        $this->assertNull($submission->email_error);
    }

    public function test_contact_notification_action_records_email_failures(): void
    {
        Mail::shouldReceive('to')
            ->once()
            ->andThrow(new RuntimeException('SMTP unavailable'));

        $submission = ContactSubmission::factory()->create();

        app(SendContactSubmissionNotificationAction::class)->handle($submission);

        $this->assertSame('SMTP unavailable', $submission->refresh()->email_error);
        $this->assertNull($submission->email_sent_at);
    }

    public function test_process_request_submission_job_delegates_to_action(): void
    {
        $submission = RequestSubmission::factory()->create();
        $action = Mockery::mock(PrepareRequestSubmissionAiProcessingAction::class);

        $action->shouldReceive('handle')
            ->once()
            ->with(Mockery::on(fn (RequestSubmission $record): bool => $record->is($submission)))
            ->andReturn(RequestSubmissionAiContext::from($submission, collect()));

        (new ProcessRequestSubmissionData($submission))->handle($action);
    }

    public function test_contact_submission_mail_uses_expected_view_and_subject(): void
    {
        $mail = new ContactSubmissionReceived(ContactSubmission::factory()->make());

        $this->assertSame('New contact submission', $mail->envelope()->subject);
        $this->assertSame('emails.contact-submission-received', $mail->content()->view);
    }
}
