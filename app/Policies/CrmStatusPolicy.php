<?php

namespace App\Policies;

use App\Models\CrmStatus;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CrmStatusPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, CrmStatus $crmStatus): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, CrmStatus $crmStatus): bool
    {
        return true;
    }

    public function delete(User $user, CrmStatus $crmStatus): bool
    {
        return true;
    }

    public function restore(User $user, CrmStatus $crmStatus): bool
    {
        return true;
    }

    public function forceDelete(User $user, CrmStatus $crmStatus): bool
    {
        return true;
    }
}
