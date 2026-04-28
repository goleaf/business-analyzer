<?php

namespace App\Filament\Resources\AiPrompts\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AiPromptForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Prompt details')
                    ->schema([
                        TextInput::make('name')
                            ->label('Prompt name')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('prompt')
                            ->label('AI prompt')
                            ->required()
                            ->rows(10)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Publishing')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Is active')
                            ->default(true)
                            ->required(),
                        TextInput::make('sort_order')
                            ->label('Sort order')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
