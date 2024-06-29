<?php

namespace App\Policies;

use App\Models\CrmMean;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CrmMeanPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {

    }

    public function view(User $user, CrmMean $crmMean)
    {
    }

    public function create(User $user)
    {
    }

    public function update(User $user, CrmMean $crmMean)
    {
    }

    public function delete(User $user, CrmMean $crmMean)
    {
    }

    public function restore(User $user, CrmMean $crmMean)
    {
    }

    public function forceDelete(User $user, CrmMean $crmMean)
    {
    }
}
