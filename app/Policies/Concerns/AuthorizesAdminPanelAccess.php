<?php

namespace App\Policies\Concerns;

use App\Models\User;

trait AuthorizesAdminPanelAccess
{
    protected function isAdmin(User $user): bool
    {
        return hash_equals((string) config('business_analyzer.admin_user_email'), $user->email);
    }
}
