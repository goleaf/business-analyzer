<?php

namespace App\Filament\Resources\RequestSubmissions\Pages;

use App\Filament\Resources\RequestSubmissions\RequestSubmissionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRequestSubmissions extends ListRecords
{
    protected static string $resource = RequestSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->authorize('create'),
        ];
    }
}
