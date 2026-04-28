<?php

namespace App\Filament\Resources\RequestSubmissions\Pages;

use App\Filament\Actions\ProcessRequestSubmissionDataAction;
use App\Filament\Resources\RequestSubmissions\RequestSubmissionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRequestSubmission extends EditRecord
{
    protected static string $resource = RequestSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ProcessRequestSubmissionDataAction::make(),
            ViewAction::make()
                ->authorize('view'),
            DeleteAction::make()
                ->authorize('delete'),
        ];
    }
}
