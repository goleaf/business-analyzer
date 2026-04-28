<?php

namespace App\Models;

use App\Enums\AiProcessingStatus;
use App\Enums\RequestSubmissionStatus;
use Database\Factories\RequestSubmissionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'business_description',
    'achievements',
    'expected_results',
    'status',
    'admin_notes',
    'ai_processing_status',
    'ai_processing_started_at',
    'ai_processing_completed_at',
    'ai_processing_error',
])]
class RequestSubmission extends Model
{
    /** @use HasFactory<RequestSubmissionFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => RequestSubmissionStatus::class,
            'ai_processing_status' => AiProcessingStatus::class,
            'ai_processing_started_at' => 'datetime',
            'ai_processing_completed_at' => 'datetime',
        ];
    }

    /**
     * @param  Builder<RequestSubmission>  $query
     * @return Builder<RequestSubmission>
     */
    public function scopeNewest(Builder $query): Builder
    {
        return $query->orderByDesc('created_at')->orderByDesc('id');
    }

    /**
     * @param  Builder<RequestSubmission>  $query
     * @return Builder<RequestSubmission>
     */
    public function scopeSelectForAdminList(Builder $query): Builder
    {
        return $query->select([
            'id',
            'business_description',
            'achievements',
            'expected_results',
            'status',
            'admin_notes',
            'ai_processing_status',
            'ai_processing_error',
            'created_at',
            'updated_at',
        ]);
    }
}
