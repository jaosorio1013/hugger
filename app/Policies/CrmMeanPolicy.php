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
        return true;
    }

    public function view(User $user, CrmMean $crmMean)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, CrmMean $crmMean)
    {
        return true;
    }

    public function delete(User $user, CrmMean $crmMean)
    {
        return true;
    }

    public function restore(User $user, CrmMean $crmMean)
    {
        return true;
    }

    public function forceDelete(User $user, CrmMean $crmMean)
    {
        return true;
    }
}
