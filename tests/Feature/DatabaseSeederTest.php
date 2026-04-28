<?php

namespace Tests\Feature;

use App\Models\AiPrompt;
use App\Models\ContactSubmission;
use App\Models\RequestSubmission;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_creates_admin_and_demo_records(): void
    {
        $this->seed(DatabaseSeeder::class);

        $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();

        $this->assertSame('Admin', $admin->name);
        $this->assertTrue(Hash::check('password', $admin->password));
        $this->assertGreaterThanOrEqual(3, AiPrompt::query()->count());
        $this->assertGreaterThanOrEqual(2, RequestSubmission::query()->count());
        $this->assertGreaterThanOrEqual(2, ContactSubmission::query()->count());
    }

    public function test_seeded_admin_can_authenticate_to_filament(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertTrue(Auth::attempt([
            'email' => 'admin@example.com',
            'password' => 'password',
        ]));

        $this->assertAuthenticated('web');

        $this->get('/admin')->assertOk();
    }

    public function test_database_seeder_is_idempotent(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(1, User::query()->where('email', 'admin@example.com')->count());
        $this->assertSame(1, AiPrompt::query()->where('name', 'Business Growth Analysis')->count());
        $this->assertSame(1, ContactSubmission::query()->where('email', 'alex@example.com')->count());
    }
}
