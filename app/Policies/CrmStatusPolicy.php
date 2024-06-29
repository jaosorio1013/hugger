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

    }

    public function view(User $user, CrmStatus $crmStatus): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, CrmStatus $crmStatus): bool
    {
    }

    public function delete(User $user, CrmStatus $crmStatus): bool
    {
    }

    public function restore(User $user, CrmStatus $crmStatus): bool
    {
    }

    public function forceDelete(User $user, CrmStatus $crmStatus): bool
    {
    }
}
