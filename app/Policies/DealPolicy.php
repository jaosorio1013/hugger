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

    }

    public function view(User $user, Deal $deal): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Deal $deal): bool
    {
    }

    public function delete(User $user, Deal $deal): bool
    {
    }

    public function restore(User $user, Deal $deal): bool
    {
    }

    public function forceDelete(User $user, Deal $deal): bool
    {
    }
}
