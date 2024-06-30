<?php

namespace App\Policies;

use App\Models\ClientAction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientActionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, ClientAction $clientAction): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, ClientAction $clientAction): bool
    {
    }

    public function delete(User $user, ClientAction $clientAction): bool
    {
    }

    public function restore(User $user, ClientAction $clientAction): bool
    {
    }

    public function forceDelete(User $user, ClientAction $clientAction): bool
    {
    }
}
