<?php

namespace Database\Factories;

use App\Enums\ContactSubmissionStatus;
use App\Models\ContactSubmission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContactSubmission>
 */
class ContactSubmissionFactory extends Factory
{
    protected $model = ContactSubmission::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'message' => fake()->paragraphs(3, true),
            'status' => ContactSubmissionStatus::New,
            'admin_notes' => null,
            'email_sent_at' => null,
            'email_error' => null,
        ];
    }
}
