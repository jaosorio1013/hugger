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

    }

    public function view(User $user, CrmFont $crmFonts)
    {
    }

    public function create(User $user)
    {
    }

    public function update(User $user, CrmFont $crmFonts)
    {
    }

    public function delete(User $user, CrmFont $crmFonts)
    {
    }

    public function restore(User $user, CrmFont $crmFonts)
    {
    }

    public function forceDelete(User $user, CrmFont $crmFonts)
    {
    }
}
