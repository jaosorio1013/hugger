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

    }

    public function view(User $user, CrmAction $crmActions)
    {
    }

    public function create(User $user)
    {
    }

    public function update(User $user, CrmAction $crmActions)
    {
    }

    public function delete(User $user, CrmAction $crmActions)
    {
    }

    public function restore(User $user, CrmAction $crmActions)
    {
    }

    public function forceDelete(User $user, CrmAction $crmActions)
    {
    }
}
