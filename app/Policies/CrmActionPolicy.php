<?php

namespace App\Policies;

use App\Models\CrmAction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CrmActionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, CrmAction $crmActions)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, CrmAction $crmActions)
    {
        return true;
    }

    public function delete(User $user, CrmAction $crmActions)
    {
        return true;
    }

    public function restore(User $user, CrmAction $crmActions)
    {
        return true;
    }

    public function forceDelete(User $user, CrmAction $crmActions)
    {
        return true;
    }
}
