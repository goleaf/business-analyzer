<?php

namespace App\Actions;

use App\Mail\ContactSubmissionReceived;
use App\Models\ContactSubmission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendContactSubmissionNotificationAction
{
    public function handle(ContactSubmission $submission): void
    {
        $adminEmail = config('business_analyzer.admin_email');

        try {
            Mail::to($adminEmail)->send(new ContactSubmissionReceived($submission));

            $submission->update([
                'email_sent_at' => now(),
                'email_error' => null,
            ]);
        } catch (Throwable $exception) {
            $submission->update([
                'email_error' => $exception->getMessage(),
            ]);

            Log::warning('Contact submission email failed.', [
                'contact_submission_id' => $submission->id,
                'admin_email' => $adminEmail,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
