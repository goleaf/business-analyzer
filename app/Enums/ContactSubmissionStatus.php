<?php

namespace App\Enums;

enum ContactSubmissionStatus: string
{
    case New = 'new';
    case Reviewed = 'reviewed';
    case Archived = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::New => 'New',
            self::Reviewed => 'Reviewed',
            self::Archived => 'Archived',
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
