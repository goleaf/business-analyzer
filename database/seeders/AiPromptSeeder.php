<?php

namespace Database\Seeders;

use App\Models\AiPrompt;
use Illuminate\Database\Seeder;

class AiPromptSeeder extends Seeder
{
    public function run(): void
    {
        AiPrompt::query()->updateOrCreate(
            ['name' => 'Business Growth Analysis'],
            [
                'prompt' => 'Analyze the saved business request data and identify practical growth opportunities. Use only the submitted business description, achievements, and expected results.',
                'sort_order' => 10,
            ],
        );

        AiPrompt::query()->updateOrCreate(
            ['name' => 'Operational Risk Review'],
            [
                'prompt' => 'Review the saved request for operational risks, missing context, and assumptions that should be clarified before final analysis.',
                'sort_order' => 20,
            ],
        );

        AiPrompt::query()->updateOrCreate(
            ['name' => 'Executive Summary Prompt'],
            [
                'prompt' => 'Summarize the analysis into a concise executive brief with prioritized next steps.',
                'sort_order' => 30,
            ],
        );
    }
}
