<?php

namespace App\Ai;

use App\Models\AiPrompt;
use App\Models\RequestSubmission;
use Illuminate\Support\Collection;

final readonly class RequestSubmissionAiContext
{
    /**
     * @param  array<int, array{id: int, name: string, prompt: string, sort_order: int}>  $prompts
     */
    public function __construct(
        public int $requestSubmissionId,
        public string $businessDescription,
        public string $achievements,
        public string $expectedResults,
        public array $prompts,
    ) {
    }

    /**
     * @param  Collection<int, AiPrompt>  $prompts
     */
    public static function from(RequestSubmission $submission, Collection $prompts): self
    {
        return new self(
            requestSubmissionId: $submission->id,
            businessDescription: $submission->business_description,
            achievements: $submission->achievements,
            expectedResults: $submission->expected_results,
            prompts: $prompts->map(fn (AiPrompt $prompt): array => [
                'id' => $prompt->id,
                'name' => $prompt->name,
                'prompt' => $prompt->prompt,
                'sort_order' => $prompt->sort_order,
            ])->values()->all(),
        );
    }
}
