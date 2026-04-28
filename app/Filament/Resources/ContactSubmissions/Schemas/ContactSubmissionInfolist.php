<?php

namespace App\Filament\Resources\ContactSubmissions\Schemas;

use App\Enums\ContactSubmissionStatus;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactSubmissionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Submitted message')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('email')
                            ->label('Email address'),
                        TextEntry::make('message')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Admin management')
                    ->schema([
                        TextEntry::make('status')
                            ->formatStateUsing(fn ($state): string => $state instanceof ContactSubmissionStatus ? $state->label() : (ContactSubmissionStatus::tryFrom((string) $state)?->label() ?? '-'))
                            ->badge(),
                        TextEntry::make('email_sent_at')
                            ->label('Email sent at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('admin_notes')
                            ->label('Admin notes')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('email_error')
                            ->label('Email error')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
