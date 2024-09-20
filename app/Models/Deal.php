<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Deal extends Model
{
    use SoftDeletes, HasFactory;

    use LogsActivity;

    public const DEFAULT_CHART_MONTHS = 5;

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

        self::saving(function (Deal $deal) {

        });

        self::saved(function (Deal $deal) {
            // if ($deal->owner_id === null && $deal->owner_id !== null) {
            //     $deal->owner_id = $deal->client->;
            //     $deal->save();
            // }

            if ($deal->client_name === null && $deal->client_id !== null) {
                $deal->client_name = $deal->client->name;
                $deal->save();
            }
        });
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(ClientContact::class, 'client_contact_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(DealDetail::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'deal_details', 'deal_id', 'product_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Venta')
            ->logFillable()
            ->logOnlyDirty();
    }

    public static function getMonthsFromFirstDealToNow(): int
    {
        return (int)Deal::query()
            ->orderBy('date')
            ->selectRaw(
                'PERIOD_DIFF( EXTRACT(YEAR_MONTH FROM CURRENT_DATE), EXTRACT(YEAR_MONTH FROM date) ) AS number_of_months'
            )
            ->take(1)
            ->value('number_of_months');
    }
}
