<?php

namespace App\Policies;

use App\Models\ContactSubmission;
use App\Models\User;
use App\Policies\Concerns\AuthorizesAdminPanelAccess;

class ContactSubmissionPolicy
{
    use AuthorizesAdminPanelAccess;

    public function viewAny(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function view(User $user, ContactSubmission $contactSubmission): bool
    {
        return $this->isAdmin($user);
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, ContactSubmission $contactSubmission): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, ContactSubmission $contactSubmission): bool
    {
        return $this->isAdmin($user);
    }

    public function deleteAny(User $user): bool
    {
        return $this->isAdmin($user);
    }
}
