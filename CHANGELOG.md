# Changelog

All notable changes to this project are documented here.

Update this file for every user-visible, operational, or architectural change.

## 2026-04-28

### Added

- Created Laravel 13 application structure for Business Analyzer.
- Added class-based Livewire public pages for About, Request, and Contact.
- Added request submission storage with validation, model, factory, migration, seeder, and tests.
- Added contact submission storage with validation, email notification handling, model, factory, migration, seeder, and tests.
- Added AI prompt storage with model, factory, migration, seeder, Filament resource, and tests.
- Added Filament admin resources for request submissions, contact submissions, and AI prompts.
- Added Filament `Process Data` action for saved request submissions.
- Added AI processing preparation action and queued job without final AI output logic.
- Added seeded Filament admin user for `/admin`.
- Added database-backed cache, session, queue, failed job, and maintenance configuration.
- Added SQLite database setup using `database/database.sqlite`.
- Added project README with setup, admin access, environment, testing, and changelog policy.
- Added a local frontend asset policy requiring CSS and JavaScript libraries to be installed with npm and loaded from `node_modules`.
- Added tests that prevent remote CSS and JavaScript asset references.
- Added a manual ChatGPT API smoke-test command that uses the Laravel AI SDK OpenAI provider.
- Added a fake-backed test for the ChatGPT smoke-test command.
- Removed literal Cyrillic characters from the language-rule test while keeping the no-Cyrillic enforcement.
- Converted the admin panel to Filament resources for request submissions, contact submissions, and AI prompts.
- Added Filament policies and restricted `/admin` access to the configured admin user email.
- Added a Filament `Process Data` action for saved request submissions.
- Added Filament resource tests for admin access, resource lists, validation, database-backed AI prompts, and the processing action.

### Removed

- Removed previous admin packages, controllers, form requests, middleware, routes, config, view overrides, and npm-only admin asset overrides.
- Removed unused legacy admin npm packages.

### Verified

- Ran database migrations and seeders.
- Ran PHPUnit feature and unit tests.
- Ran frontend production asset build.
