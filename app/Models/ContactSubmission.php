<?php

namespace App\Models;

use App\Enums\ContactSubmissionStatus;
use Database\Factories\ContactSubmissionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'email',
    'message',
    'status',
    'admin_notes',
    'email_sent_at',
    'email_error',
])]
class ContactSubmission extends Model
{
    /** @use HasFactory<ContactSubmissionFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => ContactSubmissionStatus::class,
            'email_sent_at' => 'datetime',
        ];
    }

    /**
     * @param  Builder<ContactSubmission>  $query
     * @return Builder<ContactSubmission>
     */
    public function scopeNewest(Builder $query): Builder
    {
        return $query->orderByDesc('created_at')->orderByDesc('id');
    }

    /**
     * @param  Builder<ContactSubmission>  $query
     * @return Builder<ContactSubmission>
     */
    public function scopeSelectForAdminList(Builder $query): Builder
    {
        return $query->select([
            'id',
            'name',
            'email',
            'message',
            'status',
            'admin_notes',
            'email_sent_at',
            'email_error',
            'created_at',
            'updated_at',
        ]);
    }
}
