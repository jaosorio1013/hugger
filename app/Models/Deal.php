<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Deal extends Model
{
    use SoftDeletes, HasFactory;

    use LogsActivity;

    protected $fillable = [
        'code',
        'client_name',
        'date',
        'total',
        'client_id',
        'client_contact_id',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        self::created(function (Deal $deal) {
            $deal->client_name = $deal->client->name;
            $deal->save();
        });
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(ClientContact::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(DealDetail::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->dontSubmitEmptyLogs();
    }
}
