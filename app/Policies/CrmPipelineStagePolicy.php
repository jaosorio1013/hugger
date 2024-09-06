<?php

namespace App\Policies;

use App\Models\CrmPipelineStage;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CrmPipelineStagePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, CrmPipelineStage $CrmPipelineStage): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, CrmPipelineStage $CrmPipelineStage): bool
    {
        return true;
    }

    public function delete(User $user, CrmPipelineStage $CrmPipelineStage): bool
    {
        return true;
    }

    public function restore(User $user, CrmPipelineStage $CrmPipelineStage): bool
    {
        return true;
    }

    public function forceDelete(User $user, CrmPipelineStage $CrmPipelineStage): bool
    {
        return true;
    }
}
