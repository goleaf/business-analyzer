<?php

namespace Database\Seeders;

use App\Enums\AiProcessingStatus;
use App\Enums\RequestSubmissionStatus;
use App\Models\RequestSubmission;
use Illuminate\Database\Seeder;

class RequestSubmissionSeeder extends Seeder
{
    public function run(): void
    {
        RequestSubmission::query()->updateOrCreate(
            ['business_description' => 'A subscription analytics platform for small agencies.'],
            [
                'achievements' => 'Reached 120 paying customers, reduced monthly churn, and launched self-service onboarding.',
                'expected_results' => 'Identify the best growth channels and the next operational priorities.',
                'status' => RequestSubmissionStatus::New,
                'admin_notes' => null,
                'ai_processing_status' => AiProcessingStatus::NotStarted,
                'ai_processing_started_at' => null,
                'ai_processing_completed_at' => null,
                'ai_processing_error' => null,
            ],
        );

        RequestSubmission::query()->updateOrCreate(
            ['business_description' => 'A boutique consulting firm expanding from referrals into content-led acquisition.'],
            [
                'achievements' => 'Closed three enterprise retainers and documented repeatable client onboarding.',
                'expected_results' => 'Prioritize offer positioning, lead qualification, and near-term sales process improvements.',
                'status' => RequestSubmissionStatus::InReview,
                'admin_notes' => 'Review positioning before processing.',
                'ai_processing_status' => AiProcessingStatus::Prepared,
                'ai_processing_started_at' => now(),
                'ai_processing_completed_at' => now(),
                'ai_processing_error' => null,
            ],
        );
    }
}
