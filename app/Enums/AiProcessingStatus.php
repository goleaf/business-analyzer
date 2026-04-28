<?php

namespace App\Enums;

enum AiProcessingStatus: string
{
    case NotStarted = 'not_started';
    case Queued = 'queued';
    case Prepared = 'prepared';
    case Failed = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::NotStarted => 'Not started',
            self::Queued => 'Queued',
            self::Prepared => 'Prepared',
            self::Failed => 'Failed',
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
