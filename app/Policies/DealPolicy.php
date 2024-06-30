<?php

namespace App\Policies;

use App\Models\Deal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DealPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Deal $deal): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Deal $deal): bool
    {
        return true;
    }

    public function delete(User $user, Deal $deal): bool
    {
        return true;
    }

    public function restore(User $user, Deal $deal): bool
    {
        return true;
    }

    public function forceDelete(User $user, Deal $deal): bool
    {
        return true;
    }
}
