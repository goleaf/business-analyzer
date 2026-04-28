<?php

namespace App\Actions;

use Laravel\Ai\AnonymousAgent;
use Laravel\Ai\Providers\Tools\WebSearch;

class RunChatGptSmokeTestAction
{
    /**
     * @return array{
     *     text: string,
     *     provider: string|null,
     *     model: string|null,
     *     usage: array<string, int>,
     *     citations: array<int, mixed>
     * }
     */
    public function handle(
        string $prompt,
        bool $webSearch = false,
        ?string $city = null,
        ?string $region = null,
        ?string $country = null,
    ): array {
        $tools = [];

        if ($webSearch) {
            $search = new WebSearch(
                maxSearches: (int) config('business_analyzer.ai_smoke_test.web_search_max', 3),
            );

            if (filled($city) || filled($region) || filled($country)) {
                $search->location($city, $region, $country);
            }

            $tools[] = $search;
        }

        $response = (new AnonymousAgent('', [], $tools))->prompt(
            prompt: $prompt,
            provider: config('business_analyzer.ai_smoke_test.provider'),
            model: config('business_analyzer.ai_smoke_test.model') ?: null,
            timeout: (int) config('business_analyzer.ai_smoke_test.timeout', 45),
        );

        return [
            'text' => $response->text,
            'provider' => $response->meta->provider,
            'model' => $response->meta->model,
            'usage' => $response->usage->toArray(),
            'citations' => $response->meta->citations->all(),
        ];
    }
}
