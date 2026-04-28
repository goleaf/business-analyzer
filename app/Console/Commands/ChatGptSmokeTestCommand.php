<?php

namespace App\Console\Commands;

use App\Actions\RunChatGptSmokeTestAction;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Laravel\Ai\Ai;
use Laravel\Ai\AnonymousAgent;
use Throwable;

class ChatGptSmokeTestCommand extends Command
{
    protected $signature = 'ai:chatgpt-smoke-test
        {prompt : Prompt to send to the configured OpenAI provider}
        {--web-search : Enable the OpenAI web search provider tool}
        {--city= : Approximate city for web search context}
        {--region= : Approximate region for web search context}
        {--country= : Approximate country for web search context}';

    protected $description = 'Send a manual smoke-test prompt through the Laravel AI SDK OpenAI provider.';

    public function handle(RunChatGptSmokeTestAction $smokeTest): int
    {
        if (blank(config('ai.providers.openai.key')) && ! Ai::hasFakeGatewayFor(AnonymousAgent::class)) {
            $this->error('OPENAI_API_KEY is not configured.');

            return self::FAILURE;
        }

        $startedAt = microtime(true);

        try {
            $result = $smokeTest->handle(
                prompt: (string) $this->argument('prompt'),
                webSearch: (bool) $this->option('web-search'),
                city: $this->option('city') ?: null,
                region: $this->option('region') ?: null,
                country: $this->option('country') ?: null,
            );
        } catch (Throwable $exception) {
            $this->error('ChatGPT API request failed.');
            $this->line(class_basename($exception).': '.$exception->getMessage());

            return self::FAILURE;
        }

        $this->info('ChatGPT API request succeeded.');
        $this->line('Provider: '.($result['provider'] ?? 'unknown'));
        $this->line('Model: '.($result['model'] ?? 'unknown'));
        $this->line('Duration: '.number_format((microtime(true) - $startedAt) * 1000).' ms');
        $this->line('Prompt tokens: '.$result['usage']['prompt_tokens']);
        $this->line('Completion tokens: '.$result['usage']['completion_tokens']);
        $this->line('Citations: '.count($result['citations']));
        $this->newLine();
        $this->line('Response:');
        $this->line(Str::limit($result['text'], 2000));

        return self::SUCCESS;
    }
}
