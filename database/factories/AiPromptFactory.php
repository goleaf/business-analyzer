<?php

namespace Database\Factories;

use App\Models\AiPrompt;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AiPrompt>
 */
class AiPromptFactory extends Factory
{
    protected $model = AiPrompt::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->sentence(3),
            'prompt' => fake()->paragraphs(3, true),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }
}
