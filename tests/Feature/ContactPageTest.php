<?php

namespace Tests\Feature;

use App\Livewire\ContactPage;
use App\Mail\ContactSubmissionReceived;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use RuntimeException;
use Tests\TestCase;

class ContactPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_requires_valid_fields(): void
    {
        Livewire::test(ContactPage::class)
            ->set('email', 'not-an-email')
            ->call('submit')
            ->assertHasErrors([
                'name' => 'required',
                'email' => 'email',
                'message' => 'required',
            ]);
    }

    public function test_contact_form_submission_is_saved_and_emailed_to_admin(): void
    {
        Mail::fake();
        config(['business_analyzer.admin_email' => 'admin@example.com']);

        Livewire::test(ContactPage::class)
            ->set('name', 'Ada Lovelace')
            ->set('email', 'ada@example.com')
            ->set('message', 'Please review this business request.')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSee('Your message has been sent.');

        $this->assertDatabaseHas('contact_submissions', [
            'name' => 'Ada Lovelace',
            'email' => 'ada@example.com',
            'message' => 'Please review this business request.',
            'status' => 'new',
        ]);

        Mail::assertSent(ContactSubmissionReceived::class, function (ContactSubmissionReceived $mail): bool {
            return $mail->hasTo('admin@example.com');
        });
    }

    public function test_contact_submission_is_saved_even_when_email_fails(): void
    {
        Mail::shouldReceive('to')
            ->once()
            ->andThrow(new RuntimeException('SMTP unavailable'));

        Livewire::test(ContactPage::class)
            ->set('name', 'Grace Hopper')
            ->set('email', 'grace@example.com')
            ->set('message', 'Email failure should not prevent saving.')
            ->call('submit')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('contact_submissions', [
            'name' => 'Grace Hopper',
            'email' => 'grace@example.com',
            'message' => 'Email failure should not prevent saving.',
            'email_error' => 'SMTP unavailable',
        ]);
    }
}
