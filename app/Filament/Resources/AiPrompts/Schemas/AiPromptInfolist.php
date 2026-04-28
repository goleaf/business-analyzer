<?php

namespace App\Filament\Resources\AiPrompts\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AiPromptInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Prompt details')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Prompt name'),
                        TextEntry::make('prompt')
                            ->label('AI prompt')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Publishing')
                    ->schema([
                        IconEntry::make('is_active')
                            ->label('Is active')
                            ->boolean(),
                        TextEntry::make('sort_order')
                            ->label('Sort order')
                            ->numeric(),
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
