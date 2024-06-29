<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientContact extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'charge',
        'phone',
        'crm_font_id',
        'crm_mean_id',
    ];

    public function font(): BelongsTo
    {
        return $this->belongsTo(CrmFont::class);
    }

    public function mean(): BelongsTo
    {
        return $this->belongsTo(CrmMean::class);
    }
}
