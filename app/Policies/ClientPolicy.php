<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Client $client): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Client $client): bool
    {
    }

    public function delete(User $user, Client $client): bool
    {
    }

    public function restore(User $user, Client $client): bool
    {
    }

    public function forceDelete(User $user, Client $client): bool
    {
    }
}
