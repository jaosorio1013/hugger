<?php

namespace App\Policies;

use App\Models\CrmState;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CrmStatePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, CrmState $crmState)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, CrmState $crmState)
    {
        return true;
    }

    public function delete(User $user, CrmState $crmState)
    {
        return true;
    }

    public function restore(User $user, CrmState $crmState)
    {
        return true;
    }

    public function forceDelete(User $user, CrmState $crmState)
    {
        return true;
    }
}
