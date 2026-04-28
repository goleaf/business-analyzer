<?php

namespace App\Filament\Resources\ContactSubmissions\Tables;

use App\Enums\ContactSubmissionStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContactSubmissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('message')
                    ->label('Message preview')
                    ->limit(80)
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => self::contactStatusLabel($state))
                    ->color(fn ($state): string => match (self::contactStatusValue($state)) {
                        ContactSubmissionStatus::New->value => 'gray',
                        ContactSubmissionStatus::Reviewed->value => 'success',
                        ContactSubmissionStatus::Archived->value => 'info',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email_sent_at')
                    ->label('Email sent at')
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
                    ->options(ContactSubmissionStatus::options()),
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
            ->recordActions([
                ViewAction::make()
                    ->authorize('view'),
                EditAction::make()
                    ->authorize('update'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->authorize('deleteAny')
                        ->authorizeIndividualRecords('delete'),
                ]),
            ]);
    }

    private static function contactStatusLabel(mixed $state): string
    {
        return $state instanceof ContactSubmissionStatus
            ? $state->label()
            : (ContactSubmissionStatus::tryFrom((string) $state)?->label() ?? '-');
    }

    private static function contactStatusValue(mixed $state): string
    {
        return $state instanceof ContactSubmissionStatus ? $state->value : (string) $state;
    }
}
