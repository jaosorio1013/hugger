<?php

namespace App\Policies;

use App\Models\ClientContact;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientContactPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ClientContact $clientContact): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, ClientContact $clientContact): bool
    {
        return true;
    }

    public function delete(User $user, ClientContact $clientContact): bool
    {
        return true;
    }

    public function restore(User $user, ClientContact $clientContact): bool
    {
        return true;
    }

    public function forceDelete(User $user, ClientContact $clientContact): bool
    {
        return true;
    }
}
