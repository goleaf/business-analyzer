<?php

namespace App\Filament\Resources\ContactSubmissions\Schemas;

use App\Enums\ContactSubmissionStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactSubmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Submitted message')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Textarea::make('message')
                            ->required()
                            ->rows(8)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Admin management')
                    ->schema([
                        Select::make('status')
                            ->options(ContactSubmissionStatus::options())
                            ->default(ContactSubmissionStatus::New->value)
                            ->required(),
                        DateTimePicker::make('email_sent_at')
                            ->label('Email sent at'),
                        Textarea::make('admin_notes')
                            ->label('Admin notes')
                            ->rows(4)
                            ->columnSpanFull(),
                        Textarea::make('email_error')
                            ->label('Email error')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
