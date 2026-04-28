<?php

namespace Database\Factories;

use App\Enums\AiProcessingStatus;
use App\Enums\RequestSubmissionStatus;
use App\Models\RequestSubmission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RequestSubmission>
 */
class RequestSubmissionFactory extends Factory
{
    protected $model = RequestSubmission::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'business_description' => fake()->paragraphs(2, true),
            'achievements' => fake()->paragraphs(2, true),
            'expected_results' => fake()->paragraphs(2, true),
            'status' => RequestSubmissionStatus::New,
            'admin_notes' => null,
            'ai_processing_status' => AiProcessingStatus::NotStarted,
            'ai_processing_started_at' => null,
            'ai_processing_completed_at' => null,
            'ai_processing_error' => null,
        ];
    }
}
