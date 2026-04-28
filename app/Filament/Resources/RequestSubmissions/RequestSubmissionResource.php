<?php

namespace App\Filament\Resources\RequestSubmissions;

use App\Filament\Resources\RequestSubmissions\Pages\CreateRequestSubmission;
use App\Filament\Resources\RequestSubmissions\Pages\EditRequestSubmission;
use App\Filament\Resources\RequestSubmissions\Pages\ListRequestSubmissions;
use App\Filament\Resources\RequestSubmissions\Schemas\RequestSubmissionForm;
use App\Filament\Resources\RequestSubmissions\Tables\RequestSubmissionsTable;
use App\Models\RequestSubmission;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RequestSubmissionResource extends Resource
{
    protected static ?string $model = RequestSubmission::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInbox;

    protected static ?string $navigationLabel = 'Request Submissions';

    protected static ?string $modelLabel = 'Request Submission';

    protected static ?string $pluralModelLabel = 'Request Submissions';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return RequestSubmissionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RequestSubmissionsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->select([
                'id',
                'business_description',
                'achievements',
                'expected_results',
                'status',
                'admin_notes',
                'ai_processing_status',
                'ai_processing_started_at',
                'ai_processing_completed_at',
                'ai_processing_error',
                'created_at',
                'updated_at',
            ])
            ->newest();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRequestSubmissions::route('/'),
            'create' => CreateRequestSubmission::route('/create'),
            'edit' => EditRequestSubmission::route('/{record}/edit'),
        ];
    }
}
