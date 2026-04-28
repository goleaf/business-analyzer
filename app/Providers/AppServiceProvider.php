<?php

namespace App\Providers;

use App\Models\AiPrompt;
use App\Models\ContactSubmission;
use App\Models\RequestSubmission;
use App\Policies\AiPromptPolicy;
use App\Policies\ContactSubmissionPolicy;
use App\Policies\RequestSubmissionPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(AiPrompt::class, AiPromptPolicy::class);
        Gate::policy(ContactSubmission::class, ContactSubmissionPolicy::class);
        Gate::policy(RequestSubmission::class, RequestSubmissionPolicy::class);
    }
}
