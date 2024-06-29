<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes, HasFactory;

    public const TYPE_NATURAL = 1;
    public const TYPE_COMPANY = 2;
    public const TYPE_ALLIED = 3;

    protected $fillable = [
        'name',
        'nit',
        'phone',
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

    public function contacts(): HasMany
    {
        return $this->hasMany(ClientContact::class);
    }
}
