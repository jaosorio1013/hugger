<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailchimpCampaign extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'mailchimp_id',
        'name',
        'subject',
    ];
}
