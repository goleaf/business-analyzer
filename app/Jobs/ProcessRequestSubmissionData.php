<?php

namespace App\Jobs;

use App\Actions\PrepareRequestSubmissionAiProcessingAction;
use App\Models\RequestSubmission;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessRequestSubmissionData implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public RequestSubmission $requestSubmission,
    ) {
    }

    public function handle(PrepareRequestSubmissionAiProcessingAction $action): void
    {
        $action->handle($this->requestSubmission);
    }
}
