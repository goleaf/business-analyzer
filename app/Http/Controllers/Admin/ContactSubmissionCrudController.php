<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContactSubmissionStatus;
use App\Http\Requests\Admin\ContactSubmissionRequest;
use App\Models\ContactSubmission;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class ContactSubmissionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    public function setup(): void
    {
        CRUD::setModel(ContactSubmission::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/contact-submissions');
        CRUD::setEntityNameStrings('contact submission', 'contact submissions');
    }

    protected function setupListOperation(): void
    {
        CRUD::addClause(fn ($query) => $query->selectForAdminList());
        CRUD::orderBy('created_at', 'desc');

        CRUD::addColumns([
            ['name' => 'id', 'label' => 'ID', 'type' => 'number'],
            ['name' => 'name', 'label' => 'Name', 'type' => 'text'],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email'],
            ['name' => 'message', 'label' => 'Message preview', 'type' => 'text', 'limit' => 100],
            ['name' => 'status', 'label' => 'Status', 'type' => 'enum', 'enum_function' => 'label'],
            ['name' => 'email_sent_at', 'label' => 'Email sent at', 'type' => 'datetime'],
            ['name' => 'created_at', 'label' => 'Created date', 'type' => 'datetime'],
        ]);

        $this->addStatusFilterIfAvailable();
    }

    protected function setupShowOperation(): void
    {
        CRUD::addColumns([
            ['name' => 'id', 'label' => 'ID', 'type' => 'number'],
            ['name' => 'name', 'label' => 'Name', 'type' => 'text'],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email'],
            ['name' => 'message', 'label' => 'Message', 'type' => 'textarea'],
            ['name' => 'status', 'label' => 'Status', 'type' => 'enum', 'enum_function' => 'label'],
            ['name' => 'admin_notes', 'label' => 'Admin notes', 'type' => 'textarea'],
            ['name' => 'email_sent_at', 'label' => 'Email sent at', 'type' => 'datetime'],
            ['name' => 'email_error', 'label' => 'Email error', 'type' => 'textarea'],
            ['name' => 'created_at', 'label' => 'Created date', 'type' => 'datetime'],
            ['name' => 'updated_at', 'label' => 'Updated date', 'type' => 'datetime'],
        ]);
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(ContactSubmissionRequest::class);
        $this->addFormFields();
    }

    protected function setupUpdateOperation(): void
    {
        CRUD::setValidation(ContactSubmissionRequest::class);
        $this->addFormFields();
    }

    private function addFormFields(): void
    {
        CRUD::addFields([
            ['name' => 'name', 'label' => 'Name', 'type' => 'text'],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email'],
            ['name' => 'message', 'label' => 'Message', 'type' => 'textarea'],
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'select_from_array',
                'options' => ContactSubmissionStatus::options(),
                'allows_null' => false,
            ],
            ['name' => 'admin_notes', 'label' => 'Admin notes', 'type' => 'textarea'],
        ]);
    }

    private function addStatusFilterIfAvailable(): void
    {
        if (! \Composer\InstalledVersions::isInstalled('backpack/pro')) {
            return;
        }

        CRUD::filter('status')
            ->type('dropdown')
            ->label('Status')
            ->values(ContactSubmissionStatus::options())
            ->whenActive(fn (string $value) => CRUD::addClause('where', 'status', $value));
    }
}
