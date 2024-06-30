<?php

namespace App\Policies;

use App\Models\MailchimpCampaign;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MailchimpCampaignPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, MailchimpCampaign $mailchimpCampaigns): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, MailchimpCampaign $mailchimpCampaigns): bool
    {
        return true;
    }

    public function delete(User $user, MailchimpCampaign $mailchimpCampaigns): bool
    {
        return true;
    }

    public function restore(User $user, MailchimpCampaign $mailchimpCampaigns): bool
    {
        return true;
    }

    public function forceDelete(User $user, MailchimpCampaign $mailchimpCampaigns): bool
    {
        return true;
    }
}
