<?php

namespace App\Filament\Resources\RequestSubmissions\Schemas;

use App\Enums\AiProcessingStatus;
use App\Enums\RequestSubmissionStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RequestSubmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Submitted data')
                    ->schema([
                        Textarea::make('business_description')
                            ->label('Business description')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),
                        Textarea::make('achievements')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),
                        Textarea::make('expected_results')
                            ->label('Expected results')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
                Section::make('Admin management')
                    ->schema([
                        Select::make('status')
                            ->options(RequestSubmissionStatus::options())
                            ->default(RequestSubmissionStatus::New->value)
                            ->required(),
                        Textarea::make('admin_notes')
                            ->label('Admin notes')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('AI processing')
                    ->schema([
                        Select::make('ai_processing_status')
                            ->label('AI processing status')
                            ->options(AiProcessingStatus::options())
                            ->default(AiProcessingStatus::NotStarted->value)
                            ->required(),
                        DateTimePicker::make('ai_processing_started_at')
                            ->label('AI processing started at'),
                        DateTimePicker::make('ai_processing_completed_at')
                            ->label('AI processing completed at'),
                        Textarea::make('ai_processing_error')
                            ->label('AI processing error')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }
}
