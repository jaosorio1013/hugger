<?php

namespace App\Policies;

use App\Models\MailchimpCampaigns;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MailchimpCampaignsPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, MailchimpCampaigns $mailchimpCampaigns): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, MailchimpCampaigns $mailchimpCampaigns): bool
    {
    }

    public function delete(User $user, MailchimpCampaigns $mailchimpCampaigns): bool
    {
    }

    public function restore(User $user, MailchimpCampaigns $mailchimpCampaigns): bool
    {
    }

    public function forceDelete(User $user, MailchimpCampaigns $mailchimpCampaigns): bool
    {
    }
}
