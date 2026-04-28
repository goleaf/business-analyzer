<?php

namespace Database\Seeders;

use App\Enums\ContactSubmissionStatus;
use App\Models\ContactSubmission;
use Illuminate\Database\Seeder;

class ContactSubmissionSeeder extends Seeder
{
    public function run(): void
    {
        ContactSubmission::query()->updateOrCreate(
            ['email' => 'alex@example.com'],
            [
                'name' => 'Alex Morgan',
                'message' => 'I would like to understand how the business analysis workflow works.',
                'status' => ContactSubmissionStatus::New,
                'admin_notes' => null,
                'email_sent_at' => now(),
                'email_error' => null,
            ],
        );

        ContactSubmission::query()->updateOrCreate(
            ['email' => 'casey@example.com'],
            [
                'name' => 'Casey Rivera',
                'message' => 'Please contact me about preparing a request submission.',
                'status' => ContactSubmissionStatus::Reviewed,
                'admin_notes' => 'Followed up by email.',
                'email_sent_at' => now(),
                'email_error' => null,
            ],
        );
    }
}
