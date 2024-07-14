<?php

namespace App\Policies;

use App\Models\CrmActionState;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CrmActionStatePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, CrmActionState $crmState)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, CrmActionState $crmState)
    {
        return true;
    }

    public function delete(User $user, CrmActionState $crmState)
    {
        return true;
    }

    public function restore(User $user, CrmActionState $crmState)
    {
        return true;
    }

    public function forceDelete(User $user, CrmActionState $crmState)
    {
        return true;
    }
}
