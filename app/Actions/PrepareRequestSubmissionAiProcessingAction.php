<?php

namespace App\Actions;

use App\Ai\RequestSubmissionAiContext;
use App\Enums\AiProcessingStatus;
use App\Models\AiPrompt;
use App\Models\RequestSubmission;
use Illuminate\Support\Facades\Log;
use Throwable;

class PrepareRequestSubmissionAiProcessingAction
{
    public function handle(RequestSubmission $submission): RequestSubmissionAiContext
    {
        try {
            $submission->update([
                'ai_processing_status' => AiProcessingStatus::Queued,
                'ai_processing_started_at' => now(),
                'ai_processing_completed_at' => null,
                'ai_processing_error' => null,
            ]);

            $prompts = AiPrompt::query()
                ->active()
                ->ordered()
                ->selectForProcessing()
                ->get();

            $context = RequestSubmissionAiContext::from($submission->refresh(), $prompts);

            Log::info('Request submission AI processing prepared.', [
                'request_submission_id' => $context->requestSubmissionId,
                'active_prompt_ids' => $prompts->pluck('id')->all(),
            ]);

            $submission->update([
                'ai_processing_status' => AiProcessingStatus::Prepared,
                'ai_processing_completed_at' => now(),
            ]);

            return $context;
        } catch (Throwable $exception) {
            $submission->update([
                'ai_processing_status' => AiProcessingStatus::Failed,
                'ai_processing_completed_at' => now(),
                'ai_processing_error' => $exception->getMessage(),
            ]);

            Log::error('Request submission AI processing preparation failed.', [
                'request_submission_id' => $submission->id,
                'error' => $exception->getMessage(),
            ]);

            throw $exception;
        }
    }
}
