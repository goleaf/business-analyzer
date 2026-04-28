<?php

namespace App\Actions;

use App\Models\AiPrompt;

class MoveAiPromptAction
{
    public function up(AiPrompt $prompt): bool
    {
        return $this->move($prompt, -1);
    }

    public function down(AiPrompt $prompt): bool
    {
        return $this->move($prompt, 1);
    }

    private function move(AiPrompt $prompt, int $step): bool
    {
        return $prompt->getConnection()->transaction(function () use ($prompt, $step): bool {
            $prompts = AiPrompt::query()
                ->select(['id', 'name', 'prompt', 'sort_order', 'created_at'])
                ->ordered()
                ->get();

            $promptIds = $prompts->modelKeys();

            $currentIndex = array_search($prompt->getKey(), $promptIds, true);

            if ($currentIndex === false) {
                return false;
            }

            $targetIndex = $currentIndex + $step;

            if (! array_key_exists($targetIndex, $promptIds)) {
                return false;
            }

            [$promptIds[$currentIndex], $promptIds[$targetIndex]] = [$promptIds[$targetIndex], $promptIds[$currentIndex]];

            $promptsById = $prompts->keyBy('id');
            $updatedAt = now();
            $updates = array_map(
                function (int|string $promptId, int $index) use ($promptsById, $updatedAt): array {
                    /** @var AiPrompt $orderedPrompt */
                    $orderedPrompt = $promptsById->get($promptId);

                    return [
                        'id' => $promptId,
                        'name' => $orderedPrompt->name,
                        'prompt' => $orderedPrompt->prompt,
                        'sort_order' => ($index + 1) * 10,
                        'created_at' => $orderedPrompt->created_at,
                        'updated_at' => $updatedAt,
                    ];
                },
                $promptIds,
                array_keys($promptIds),
            );

            AiPrompt::query()->upsert($updates, ['id'], ['sort_order', 'updated_at']);

            return true;
        });
    }
}
