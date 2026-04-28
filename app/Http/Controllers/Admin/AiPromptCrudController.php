<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AiPromptRequest;
use App\Models\AiPrompt;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class AiPromptCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    public function setup(): void
    {
        CRUD::setModel(AiPrompt::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/ai-prompts');
        CRUD::setEntityNameStrings('AI prompt', 'AI prompts');
    }

    protected function setupListOperation(): void
    {
        CRUD::addClause('select', ['id', 'name', 'prompt', 'is_active', 'sort_order', 'created_at', 'updated_at']);
        CRUD::orderBy('sort_order');
        CRUD::orderBy('name');

        CRUD::addColumns([
            ['name' => 'id', 'label' => 'ID', 'type' => 'number'],
            ['name' => 'name', 'label' => 'Name', 'type' => 'text'],
            ['name' => 'prompt', 'label' => 'Prompt preview', 'type' => 'text', 'limit' => 100],
            ['name' => 'is_active', 'label' => 'Is active', 'type' => 'boolean'],
            ['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number'],
            ['name' => 'created_at', 'label' => 'Created date', 'type' => 'datetime'],
        ]);

        $this->addActiveFilterIfAvailable();
    }

    protected function setupShowOperation(): void
    {
        CRUD::addColumns([
            ['name' => 'id', 'label' => 'ID', 'type' => 'number'],
            ['name' => 'name', 'label' => 'Name', 'type' => 'text'],
            ['name' => 'prompt', 'label' => 'AI prompt', 'type' => 'textarea'],
            ['name' => 'is_active', 'label' => 'Is active', 'type' => 'boolean'],
            ['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number'],
            ['name' => 'created_at', 'label' => 'Created date', 'type' => 'datetime'],
            ['name' => 'updated_at', 'label' => 'Updated date', 'type' => 'datetime'],
        ]);
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(AiPromptRequest::class);
        $this->addFormFields();
    }

    protected function setupUpdateOperation(): void
    {
        CRUD::setValidation(AiPromptRequest::class);
        $this->addFormFields();
    }

    private function addFormFields(): void
    {
        CRUD::addFields([
            [
                'name' => 'name',
                'label' => 'Prompt name',
                'type' => 'text',
            ],
            [
                'name' => 'prompt',
                'label' => 'AI prompt',
                'type' => 'textarea',
            ],
            [
                'name' => 'is_active',
                'label' => 'Is active',
                'type' => 'checkbox',
                'default' => true,
            ],
            [
                'name' => 'sort_order',
                'label' => 'Sort order',
                'type' => 'number',
                'default' => 0,
            ],
        ]);
    }

    private function addActiveFilterIfAvailable(): void
    {
        if (! \Composer\InstalledVersions::isInstalled('backpack/pro')) {
            return;
        }

        CRUD::filter('is_active')
            ->type('dropdown')
            ->label('Is active')
            ->values([1 => 'Active', 0 => 'Inactive'])
            ->whenActive(fn (string $value) => CRUD::addClause('where', 'is_active', (bool) $value));
    }
}
