<?php

namespace Tests\Feature;

use Laravel\Ai\Ai;
use Laravel\Ai\AnonymousAgent;
use Tests\TestCase;

class ChatGptSmokeTestCommandTest extends TestCase
{
    public function test_chatgpt_smoke_test_command_sends_prompt_through_laravel_ai_sdk(): void
    {
        Ai::fakeAgent(AnonymousAgent::class, ['Fake weather response for Vilnius.']);

        $prompt = 'weather in vilnius, lithuania this week';

        $this->artisan('ai:chatgpt-smoke-test', [
            'prompt' => $prompt,
            '--web-search' => true,
            '--city' => 'Vilnius',
            '--country' => 'LT',
        ])
            ->expectsOutputToContain('ChatGPT API request succeeded.')
            ->expectsOutputToContain('Fake weather response for Vilnius.')
            ->assertSuccessful();

        Ai::assertAgentWasPrompted(
            AnonymousAgent::class,
            fn ($agentPrompt) => $agentPrompt->prompt === $prompt
                && $agentPrompt->provider->name() === 'openai'
        );
    }
}
