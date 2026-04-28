<?php

namespace App\Filament\Resources\RequestSubmissions\Pages;

use App\Filament\Actions\ProcessRequestSubmissionDataAction;
use App\Filament\Resources\RequestSubmissions\RequestSubmissionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRequestSubmission extends ViewRecord
{
    protected static string $resource = RequestSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ProcessRequestSubmissionDataAction::make(),
            EditAction::make()
                ->authorize('update'),
        ];
    }
}
