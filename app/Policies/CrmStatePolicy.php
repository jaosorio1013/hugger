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

    }

    public function view(User $user, CrmState $crmState)
    {
    }

    public function create(User $user)
    {
    }

    public function update(User $user, CrmState $crmState)
    {
    }

    public function delete(User $user, CrmState $crmState)
    {
    }

    public function restore(User $user, CrmState $crmState)
    {
    }

    public function forceDelete(User $user, CrmState $crmState)
    {
    }
}
