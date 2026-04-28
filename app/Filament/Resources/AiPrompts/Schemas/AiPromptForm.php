<?php

namespace App\Filament\Resources\AiPrompts\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
            ]);
    }
}
