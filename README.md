# Business Analyzer

Business Analyzer is a Laravel application for collecting business analysis requests, managing submitted data in Backpack, and preparing saved request data for a later AI processing workflow.

## Stack

- Laravel 13
- PHP 8.3+
- Backpack for Laravel 7
- Livewire 4 class-based public pages
- Tailwind CSS 4
- Laravel AI SDK
- SQLite database storage

## Main Features

- Public About page.
- Public Request page with a Livewire form.
- Public Contact page with a Livewire form.
- Database-backed request submissions, contact submissions, AI prompts, cache, sessions, queues, and failed jobs.
- Backpack admin CRUDs for request submissions, contact submissions, and AI prompts.
- Backpack `Process Data` action for saved request submissions.
- Seeded admin user for `/admin`.

## Local Setup

Install dependencies:

```bash
composer install
npm install
```

Create the environment file and application key:

```bash
cp .env.example .env
php artisan key:generate
```

Create the SQLite database file:

```bash
touch database/database.sqlite
```

Run migrations and seeders:

```bash
php artisan migrate --seed
```

Build frontend assets:

```bash
npm run build
```

Start the local server:

```bash
php artisan serve
```

## Environment

The app is configured to use SQLite and database-backed framework storage:

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
CACHE_STORE=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database
APP_MAINTENANCE_DRIVER=cache
APP_MAINTENANCE_STORE=database
```

Set these values locally:

```env
ADMIN_EMAIL=admin@example.com
OPENAI_API_KEY=
```

Do not commit real API keys or secrets.

## Admin Access

After running the seeders, the Backpack admin panel is available at:

```text
/admin
```

Seeded local credentials:

```text
Email: admin@example.com
Password: password
```

## AI Processing

AI prompt text is stored in the `ai_prompts` table and managed from Backpack. Request submissions expose a `Process Data` action that dispatches the processing job for saved records only.

The final AI output logic is intentionally not implemented yet. The current structure prepares saved request data and active prompts so the exact processing rules can be added later.

## Testing

Run the test suite:

```bash
php artisan test
```

Run the production asset build:

```bash
npm run build
```

## Changelog Policy

Update [CHANGELOG.md](CHANGELOG.md) for every user-visible, operational, or architectural change. Keep entries in English and group changes by date.
