<?php

namespace Tests\Feature;

use App\Enums\ContactSubmissionStatus;
use App\Enums\RequestSubmissionStatus;
use App\Http\Requests\Admin\AiPromptRequest;
use App\Http\Requests\Admin\ContactSubmissionRequest;
use App\Http\Requests\Admin\RequestSubmissionRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class AdminRequestValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_form_requests_authorize_backpack_users(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin, 'backpack');

        $this->assertTrue((new AiPromptRequest)->authorize());
        $this->assertTrue((new ContactSubmissionRequest)->authorize());
        $this->assertTrue((new RequestSubmissionRequest)->authorize());
    }

    public function test_ai_prompt_request_validation_rules(): void
    {
        $validator = Validator::make([
            'name' => 'Market Positioning',
            'prompt' => 'Analyze market positioning.',
            'is_active' => true,
            'sort_order' => 1,
        ], (new AiPromptRequest)->rules());

        $this->assertFalse($validator->fails());
    }

    public function test_request_submission_request_validation_rules(): void
    {
        $validator = Validator::make([
            'business_description' => 'Business description',
            'achievements' => 'Achievements',
            'expected_results' => 'Expected results',
            'status' => RequestSubmissionStatus::New->value,
            'admin_notes' => null,
        ], (new RequestSubmissionRequest)->rules());

        $this->assertFalse($validator->fails());
    }

    public function test_contact_submission_request_validation_rules(): void
    {
        $validator = Validator::make([
            'name' => 'Taylor',
            'email' => 'taylor@example.com',
            'message' => 'Contact message',
            'status' => ContactSubmissionStatus::New->value,
            'admin_notes' => null,
        ], (new ContactSubmissionRequest)->rules());

        $this->assertFalse($validator->fails());
    }
}
