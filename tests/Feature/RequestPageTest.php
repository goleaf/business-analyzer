<?php

namespace Tests\Feature;

use App\Livewire\RequestPage;
use App\Models\RequestSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RequestPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_request_form_requires_all_fields(): void
    {
        Livewire::test(RequestPage::class)
            ->call('submit')
            ->assertHasErrors([
                'business_description' => 'required',
                'achievements' => 'required',
                'expected_results' => 'required',
            ]);
    }

    public function test_request_form_submission_is_saved(): void
    {
        Livewire::test(RequestPage::class)
            ->set('business_description', 'A subscription analytics company serving small agencies.')
            ->set('achievements', 'Reached 120 paying customers and reduced churn this quarter.')
            ->set('expected_results', 'Identify the next three growth opportunities.')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSee('Your request has been submitted.');

        $this->assertDatabaseHas('request_submissions', [
            'business_description' => 'A subscription analytics company serving small agencies.',
            'achievements' => 'Reached 120 paying customers and reduced churn this quarter.',
            'expected_results' => 'Identify the next three growth opportunities.',
            'status' => 'new',
        ]);
    }

    public function test_admin_notes_are_not_visible_on_public_request_page(): void
    {
        RequestSubmission::factory()->create([
            'admin_notes' => 'Private admin note',
        ]);

        $this->get('/request')
            ->assertOk()
            ->assertDontSee('Private admin note');
    }
}
