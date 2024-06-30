<?php

namespace App\Policies;

use App\Models\DealDetail;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DealDetailPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, DealDetail $dealDetail): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, DealDetail $dealDetail): bool
    {
        return true;
    }

    public function delete(User $user, DealDetail $dealDetail): bool
    {
        return true;
    }

    public function restore(User $user, DealDetail $dealDetail): bool
    {
        return true;
    }

    public function forceDelete(User $user, DealDetail $dealDetail): bool
    {
        return true;
    }
}
