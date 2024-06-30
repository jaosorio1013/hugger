<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nnjeim\World\Models\City;

class Client extends Model
{
    use SoftDeletes, HasFactory;

    public const TYPE_NATURAL = 1;
    public const TYPE_COMPANY = 2;
    public const TYPE_ALLIED = 3;

    public const STATE_UNDEFINED = 0;
    public const STATE_CUSTOMER_PROSPECT = 1;
    public const STATE_POTENTIAL_CUSTOMER = 2;
    public const STATE_ACTIVE_CUSTOMER = 3;
    public const STATE_INACTIVE_CUSTOMER = 4;

    protected $fillable = [
        'name',
        'nit',
        'phone',
        'email',
        'address',
        'type',
        'user_id',
        'crm_font_id',
        'crm_mean_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function font(): BelongsTo
    {
        return $this->belongsTo(CrmFont::class);
    }

    public function mean(): BelongsTo
    {
        return $this->belongsTo(CrmMean::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'location_city_id');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(ClientContact::class);
    }

    public function actions(): HasMany
    {
        return $this->hasMany(ClientAction::class);
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }

    // public function mailchimp_audiences()
    // {
    //     return $this->belongsTo(MailchimpAudience::class);
    // }

    // public function tags(): BelongsToMany
    // {
    //     return $this->belongsToMany(Tag::class);
    // }
}
