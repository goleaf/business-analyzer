<?php

namespace App\Filament\Resources\RequestSubmissions\Tables;

use App\Enums\AiProcessingStatus;
use App\Enums\RequestSubmissionStatus;
use App\Filament\Actions\ProcessRequestSubmissionDataAction;
use App\Filament\Resources\RequestSubmissions\RequestSubmissionResource;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RequestSubmissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('business_description')
                    ->label('Business description preview')
                    ->limit(60)
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('achievements')
                    ->label('Achievements preview')
                    ->limit(60)
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('expected_results')
                    ->label('Expected results preview')
                    ->limit(60)
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => self::requestStatusLabel($state))
                    ->color(fn ($state): string => match (self::requestStatusValue($state)) {
                        RequestSubmissionStatus::New->value => 'gray',
                        RequestSubmissionStatus::InReview->value => 'warning',
                        RequestSubmissionStatus::Processed->value => 'success',
                        RequestSubmissionStatus::Closed->value => 'info',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('ai_processing_status')
                    ->label('AI processing status')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => self::aiProcessingStatusLabel($state))
                    ->color(fn ($state): string => match (self::aiProcessingStatusValue($state)) {
                        AiProcessingStatus::NotStarted->value => 'gray',
                        AiProcessingStatus::Queued->value => 'warning',
                        AiProcessingStatus::Prepared->value => 'success',
                        AiProcessingStatus::Failed->value => 'danger',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('ai_processing_started_at')
                    ->label('AI processing started at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('ai_processing_completed_at')
                    ->label('AI processing completed at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Created date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(RequestSubmissionStatus::options()),
                SelectFilter::make('ai_processing_status')
                    ->label('AI processing status')
                    ->options(AiProcessingStatus::options()),
                Filter::make('created_at')
                    ->label('Created date')
                    ->schema([
                        DatePicker::make('created_from')
                            ->label('Created from'),
                        DatePicker::make('created_until')
                            ->label('Created until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'] ?? null,
                                fn (Builder $query, string $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'] ?? null,
                                fn (Builder $query, string $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->recordUrl(fn (Model $record): string => RequestSubmissionResource::getUrl('edit', ['record' => $record]))
            ->recordActions([
                ProcessRequestSubmissionDataAction::make(),
                EditAction::make()
                    ->authorize('update'),
            ]);
    }

    private static function requestStatusLabel(mixed $state): string
    {
        return $state instanceof RequestSubmissionStatus
            ? $state->label()
            : (RequestSubmissionStatus::tryFrom((string) $state)?->label() ?? '-');
    }

    private static function requestStatusValue(mixed $state): string
    {
        return $state instanceof RequestSubmissionStatus ? $state->value : (string) $state;
    }

    private static function aiProcessingStatusLabel(mixed $state): string
    {
        return $state instanceof AiProcessingStatus
            ? $state->label()
            : (AiProcessingStatus::tryFrom((string) $state)?->label() ?? '-');
    }

    private static function aiProcessingStatusValue(mixed $state): string
    {
        return $state instanceof AiProcessingStatus ? $state->value : (string) $state;
    }
}
