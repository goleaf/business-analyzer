<?php

namespace App\Policies;

use App\Models\AiPrompt;
use App\Models\User;
use App\Policies\Concerns\AuthorizesAdminPanelAccess;

class AiPromptPolicy
{
    use AuthorizesAdminPanelAccess;

    public function viewAny(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function view(User $user, AiPrompt $aiPrompt): bool
    {
        return $this->isAdmin($user);
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, AiPrompt $aiPrompt): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, AiPrompt $aiPrompt): bool
    {
        return $this->isAdmin($user);
    }

    public function deleteAny(User $user): bool
    {
        return $this->isAdmin($user);
    }
}
