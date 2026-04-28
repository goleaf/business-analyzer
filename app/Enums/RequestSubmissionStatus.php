<?php

namespace App\Enums;

enum RequestSubmissionStatus: string
{
    case New = 'new';
    case InReview = 'in_review';
    case Processed = 'processed';
    case Closed = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::New => 'New',
            self::InReview => 'In review',
            self::Processed => 'Processed',
            self::Closed => 'Closed',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $status) {
            $options[$status->value] = $status->label();
        }

        return $options;
    }
}
