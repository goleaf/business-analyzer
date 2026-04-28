<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AiProcessingStatus;
use App\Enums\RequestSubmissionStatus;
use App\Http\Requests\Admin\RequestSubmissionRequest;
use App\Jobs\ProcessRequestSubmissionData;
use App\Models\RequestSubmission;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\RedirectResponse;

class RequestSubmissionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    public function setup(): void
    {
        CRUD::setModel(RequestSubmission::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/request-submissions');
        CRUD::setEntityNameStrings('request submission', 'request submissions');
    }

    protected function setupListOperation(): void
    {
        CRUD::addClause(fn ($query) => $query->selectForAdminList());
        CRUD::orderBy('created_at', 'desc');
        CRUD::addButton('line', 'process_data', 'view', 'crud::buttons.process_data', 'end');

        CRUD::addColumns([
            [
                'name' => 'id',
                'label' => 'ID',
                'type' => 'number',
            ],
            [
                'name' => 'business_description',
                'label' => 'Business description preview',
                'type' => 'text',
                'limit' => 80,
            ],
            [
                'name' => 'achievements',
                'label' => 'Achievements preview',
                'type' => 'text',
                'limit' => 80,
            ],
            [
                'name' => 'expected_results',
                'label' => 'Expected results preview',
                'type' => 'text',
                'limit' => 80,
            ],
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'enum',
                'enum_function' => 'label',
            ],
            [
                'name' => 'ai_processing_status',
                'label' => 'AI processing',
                'type' => 'enum',
                'enum_function' => 'label',
            ],
            [
                'name' => 'created_at',
                'label' => 'Created date',
                'type' => 'datetime',
            ],
        ]);

        $this->addStatusFilterIfAvailable('status', 'Status', RequestSubmissionStatus::options());
        $this->addStatusFilterIfAvailable('ai_processing_status', 'AI processing', AiProcessingStatus::options());
    }

    protected function setupShowOperation(): void
    {
        CRUD::addColumns([
            ['name' => 'id', 'label' => 'ID', 'type' => 'number'],
            ['name' => 'business_description', 'label' => 'Business description', 'type' => 'textarea'],
            ['name' => 'achievements', 'label' => 'Achievements', 'type' => 'textarea'],
            ['name' => 'expected_results', 'label' => 'Expected results', 'type' => 'textarea'],
            ['name' => 'status', 'label' => 'Status', 'type' => 'enum', 'enum_function' => 'label'],
            ['name' => 'admin_notes', 'label' => 'Admin notes', 'type' => 'textarea'],
            ['name' => 'ai_processing_status', 'label' => 'AI processing', 'type' => 'enum', 'enum_function' => 'label'],
            ['name' => 'ai_processing_error', 'label' => 'AI processing error', 'type' => 'textarea'],
            ['name' => 'created_at', 'label' => 'Created date', 'type' => 'datetime'],
            ['name' => 'updated_at', 'label' => 'Updated date', 'type' => 'datetime'],
        ]);
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(RequestSubmissionRequest::class);
        $this->addFormFields();
    }

    protected function setupUpdateOperation(): void
    {
        CRUD::setValidation(RequestSubmissionRequest::class);
        $this->addFormFields();
    }

    public function processData(RequestSubmission $requestSubmission): RedirectResponse
    {
        $requestSubmission->update([
            'ai_processing_status' => AiProcessingStatus::Queued,
            'ai_processing_error' => null,
        ]);

        ProcessRequestSubmissionData::dispatch($requestSubmission);

        \Alert::success('AI processing has been queued.')->flash();

        return redirect()->back();
    }

    private function addFormFields(): void
    {
        CRUD::addFields([
            [
                'name' => 'business_description',
                'label' => 'Business description',
                'type' => 'textarea',
            ],
            [
                'name' => 'achievements',
                'label' => 'Achievements',
                'type' => 'textarea',
            ],
            [
                'name' => 'expected_results',
                'label' => 'Expected results',
                'type' => 'textarea',
            ],
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'select_from_array',
                'options' => RequestSubmissionStatus::options(),
                'allows_null' => false,
            ],
            [
                'name' => 'admin_notes',
                'label' => 'Admin notes',
                'type' => 'textarea',
            ],
        ]);
    }

    /**
     * Backpack CRUD filters are available when Backpack Pro is installed.
     *
     * @param  array<string, string>  $options
     */
    private function addStatusFilterIfAvailable(string $column, string $label, array $options): void
    {
        if (! \Composer\InstalledVersions::isInstalled('backpack/pro')) {
            return;
        }

        CRUD::filter($column)
            ->type('dropdown')
            ->label($label)
            ->values($options)
            ->whenActive(fn (string $value) => CRUD::addClause('where', $column, $value));
    }
}
