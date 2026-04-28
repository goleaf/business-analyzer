<?php

namespace App\Policies;

use App\Models\RequestSubmission;
use App\Models\User;
use App\Policies\Concerns\AuthorizesAdminPanelAccess;

class RequestSubmissionPolicy
{
    use AuthorizesAdminPanelAccess;

    public function viewAny(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function view(User $user, RequestSubmission $requestSubmission): bool
    {
        return $this->isAdmin($user);
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, RequestSubmission $requestSubmission): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, RequestSubmission $requestSubmission): bool
    {
        return $this->isAdmin($user);
    }

    public function deleteAny(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function processData(User $user, RequestSubmission $requestSubmission): bool
    {
        return $this->isAdmin($user);
    }
}
