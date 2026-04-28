<?php

namespace App\Filament\Resources\AiPrompts\Tables;

use App\Actions\MoveAiPromptAction;
use App\Filament\Resources\AiPrompts\AiPromptResource;
use App\Models\AiPrompt;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AiPromptsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('prompt')
                    ->label('Prompt preview')
                    ->limit(80)
                    ->searchable()
                    ->toggleable(),
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
            ->recordUrl(fn (Model $record): string => AiPromptResource::getUrl('edit', ['record' => $record]))
            ->reorderable('sort_order')
            ->recordActions([
                Action::make('moveUp')
                    ->label('Move up')
                    ->icon(Heroicon::OutlinedArrowUp)
                    ->iconButton()
                    ->tooltip('Move up')
                    ->color('gray')
                    ->successNotification(null)
                    ->authorize('update')
                    ->action(fn (AiPrompt $record): bool => app(MoveAiPromptAction::class)->up($record)),
                Action::make('moveDown')
                    ->label('Move down')
                    ->icon(Heroicon::OutlinedArrowDown)
                    ->iconButton()
                    ->tooltip('Move down')
                    ->color('gray')
                    ->successNotification(null)
                    ->authorize('update')
                    ->action(fn (AiPrompt $record): bool => app(MoveAiPromptAction::class)->down($record)),
                EditAction::make()
                    ->authorize('update'),
            ]);
    }
}
