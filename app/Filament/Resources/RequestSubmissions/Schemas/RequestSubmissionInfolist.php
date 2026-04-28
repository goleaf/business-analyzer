<?php

namespace App\Filament\Resources\RequestSubmissions\Schemas;

use App\Enums\AiProcessingStatus;
use App\Enums\RequestSubmissionStatus;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RequestSubmissionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Submitted data')
                    ->schema([
                        TextEntry::make('business_description')
                            ->label('Business description')
                            ->columnSpanFull(),
                        TextEntry::make('achievements')
                            ->columnSpanFull(),
                        TextEntry::make('expected_results')
                            ->label('Expected results')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
                Section::make('Admin management')
                    ->schema([
                        TextEntry::make('status')
                            ->formatStateUsing(fn ($state): string => $state instanceof RequestSubmissionStatus ? $state->label() : (RequestSubmissionStatus::tryFrom((string) $state)?->label() ?? '-'))
                            ->badge(),
                        TextEntry::make('admin_notes')
                            ->label('Admin notes')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('AI processing')
                    ->schema([
                        TextEntry::make('ai_processing_status')
                            ->label('AI processing status')
                            ->formatStateUsing(fn ($state): string => $state instanceof AiProcessingStatus ? $state->label() : (AiProcessingStatus::tryFrom((string) $state)?->label() ?? '-'))
                            ->badge(),
                        TextEntry::make('ai_processing_started_at')
                            ->label('AI processing started at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('ai_processing_completed_at')
                            ->label('AI processing completed at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('ai_processing_error')
                            ->label('AI processing error')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }
}
