<?php

namespace App\Models;

use Database\Factories\AiPromptFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'prompt',
    'sort_order',
])]
class AiPrompt extends Model
{
    /** @use HasFactory<AiPromptFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    /**
     * @param  Builder<AiPrompt>  $query
     * @return Builder<AiPrompt>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name')->orderBy('id');
    }

    /**
     * @param  Builder<AiPrompt>  $query
     * @return Builder<AiPrompt>
     */
    public function scopeSelectForProcessing(Builder $query): Builder
    {
        return $query->select(['id', 'name', 'prompt', 'sort_order']);
    }

    public static function nextSortOrder(): int
    {
        return ((int) static::query()->max('sort_order')) + 10;
    }
}
