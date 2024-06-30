<?php

namespace App\Policies;

use App\Models\CrmFont;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CrmFontPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, CrmFont $crmFonts)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, CrmFont $crmFonts)
    {
        return true;
    }

    public function delete(User $user, CrmFont $crmFonts)
    {
        return true;
    }

    public function restore(User $user, CrmFont $crmFonts)
    {
        return true;
    }

    public function forceDelete(User $user, CrmFont $crmFonts)
    {
        return true;
    }
}
