<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ClientContact extends Model
{
    use SoftDeletes, HasFactory;

    use LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'charge',
        'phone',
        'client_id',
        'crm_font_id',
        'crm_mean_id',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function font(): BelongsTo
    {
        return $this->belongsTo(CrmFont::class);
    }

    public function mean(): BelongsTo
    {
        return $this->belongsTo(CrmMean::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Contacto')
            ->logFillable()
            ->logOnlyDirty();
    }
}
