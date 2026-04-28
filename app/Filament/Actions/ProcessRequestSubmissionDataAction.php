<?php

namespace App\Filament\Actions;

use App\Enums\AiProcessingStatus;
use App\Jobs\ProcessRequestSubmissionData;
use App\Models\RequestSubmission;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;

class ProcessRequestSubmissionDataAction
{
    public static function make(string $name = 'processData'): Action
    {
        return Action::make($name)
            ->label('Process Data')
            ->icon(Heroicon::OutlinedCpuChip)
            ->authorize('processData')
            ->requiresConfirmation()
            ->modalHeading('Process saved request data')
            ->modalDescription('This starts the AI processing workflow for the selected saved request submission.')
            ->action(function (RequestSubmission $record): void {
                $record->update([
                    'ai_processing_status' => AiProcessingStatus::Queued,
                    'ai_processing_started_at' => now(),
                    'ai_processing_completed_at' => null,
                    'ai_processing_error' => null,
                ]);

                ProcessRequestSubmissionData::dispatch($record);

                Notification::make()
                    ->title('Request data processing started')
                    ->success()
                    ->send();
            });
    }
}
