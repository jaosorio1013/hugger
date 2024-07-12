<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nnjeim\World\Models\City;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Client extends Model
{
    use SoftDeletes, HasFactory;

    use LogsActivity;

    public const TYPE_NATURAL = 1;
    public const TYPE_COMPANY = 2;
    public const TYPE_ALLIED = 3;
    public const TYPES = [
        self::TYPE_NATURAL => 'Persona Natural',
        self::TYPE_COMPANY => 'Empresa',
        self::TYPE_ALLIED => 'Aliado',
    ];

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
        'crm_status_id',
    ];

    protected $with = [
        'contacts'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function font(): BelongsTo
    {
        return $this->belongsTo(CrmFont::class, 'crm_font_id');
    }

    public function mean(): BelongsTo
    {
        return $this->belongsTo(CrmMean::class, 'crm_mean_id');
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

    public function status(): HasMany
    {
        return $this->hasMany(CrmStatus::class, 'crm_status_id');
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Cliente')
            ->logFillable()
            ->logOnlyDirty();
    }
}
