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
                'is_active' => true,
                'sort_order' => 10,
            ],
        );

        AiPrompt::query()->updateOrCreate(
            ['name' => 'Operational Risk Review'],
            [
                'prompt' => 'Review the saved request for operational risks, missing context, and assumptions that should be clarified before final analysis.',
                'is_active' => true,
                'sort_order' => 20,
            ],
        );

        AiPrompt::query()->updateOrCreate(
            ['name' => 'Archived Draft Prompt'],
            [
                'prompt' => 'This inactive prompt is kept as an editable draft in the admin panel.',
                'is_active' => false,
                'sort_order' => 90,
            ],
        );
    }
}
